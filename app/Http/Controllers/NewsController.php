<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use App\Notifications\NewNewsNotification;
use Illuminate\Support\Facades\Notification;

class NewsController extends Controller
{
    
    public function index(Request $request)
    {
        $query = News::latest()->where('status', 'approved');

        // Lấy tin nóng nhất để hiển thị to nhất (ưu tiên nếu có filter hoặc search thì vẫn lấy trong kết quả đó)
        $hotNews = null;

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $category = $request->input('category');
            if ($category === 'uncategorized') {
                $query->whereNull('category_id');
            } else {
                $query->where('category_id', $category);
            }
        }

        if ($request->filled('tag')) {
            $tagId = $request->input('tag');
            $query->whereHas('tags', function($q) use ($tagId) {
                $q->where('tags.id', $tagId);
            });
        }

        $newsAll = $query->get(); // Lấy tất cả theo query hiện tại (search/filter)
        $categories = Category::all();
        
        // Tin nóng: Lấy tất cả tin được đánh dấu là nóng (không bị ảnh hưởng bởi filter/search để làm slide)
        $featuredNews = News::where('status', 'approved')
                            ->where('is_hot', true)
                            ->latest()
                            ->get();
        
        // Nếu đang có search hoặc filter thì danh sách tin nóng (featuredNews) sẽ rỗng
        // Hoặc ta vẫn hiện tin nóng ở đầu trang nhưng danh sách dưới chỉ hiện tin theo filter.
        // Để linh hoạt, ta chỉ hiện Slide nếu ở trang chủ (không search, không category)
        if ($request->filled('search') || $request->filled('category') || $request->filled('tag')) {
            $featuredNews = collect(); // Xóa tin nổi bật nếu đang search/filter để không gây nhiễu
            $news = $query->latest()->paginate(12)->withQueryString();
        } else {
            // Loại bỏ các tin đã có trong featuredNews khỏi danh sách news bên dưới
            $featuredIds = $featuredNews->pluck('id')->toArray();
            $news = News::where('status', 'approved')
                        ->whereNotIn('id', $featuredIds)
                        ->latest()
                        ->paginate(12);
        }
        
        return view('news.index', compact('news', 'categories', 'featuredNews'));
    }

     
    public function create()
    {
        $this->authorize('create', News::class);
        $categories = Category::all();
        return view('news.create', compact('categories'));
    }

    
    public function store(Request $request)
    {
        $this->authorize('create', News::class);
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all() + [
            'user_id' => auth()->id(),
            'status' => 'pending' // Luôn để trạng thái chờ duyệt khi tạo mới
        ];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('news_images', 'public');
            $data['image_path'] = $path;
        }

        $news = News::create($data);
        
        if ($request->filled('tags')) {
            $tagNames = explode(',', $request->tags);
            $tagIds = [];
            foreach ($tagNames as $tagName) {
                $tagName = trim($tagName);
                if ($tagName) {
                    $tag = Tag::firstOrCreate(['name' => $tagName]);
                    $tagIds[] = $tag->id;
                }
            }
            $news->tags()->sync($tagIds);
        }

        return redirect()->route('news.index');
    }

    
    public function show(string $id)
    {
        $news = News::findOrFail($id);
        
        // Đếm lượt xem bài viết (tính cả khách)
        $viewed = session()->get('viewed_news', []);
        if (!in_array($id, $viewed)) {
            $news->increment('views');
            session()->push('viewed_news', $id);
        }

        $comments = $news->comments()->latest()->paginate(5);
        return view('news.show', compact('news', 'comments'));
    }

    
    public function edit($id)
    {
        $news = News::findOrFail($id);
        
        $this->authorize('update', $news);

        $categories = Category::all();
        return view('news.edit', compact('news', 'categories'));
    }

   
    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

        $this->authorize('update', $news);

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $data = $request->all();

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($news->image_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($news->image_path);
            }
            $path = $request->file('image')->store('news_images', 'public');
            $data['image_path'] = $path;
        }

        if ($news->status === 'rejected') {
            $data['status'] = 'resubmitted';
            $data['admin_note'] = null; // Clear note on resubmission
        }

        $news->update($data);

        if ($request->filled('tags')) {
            $tagNames = explode(',', $request->tags);
            $tagIds = [];
            foreach ($tagNames as $tagName) {
                $tagName = trim($tagName);
                if ($tagName) {
                    $tag = Tag::firstOrCreate(['name' => $tagName]);
                    $tagIds[] = $tag->id;
                }
            }
            $news->tags()->sync($tagIds);
        } else {
             // If input is empty string, detach all tags (optional depending on UX, but standard for text input)
             // Check if the input exists in request first to differentiate between "not updating tags" and "clearing tags".
             // For simple form submission, empty input usually means clear tags.
             if ($request->has('tags')) {
                 $news->tags()->detach();
             }
        }

        return redirect()->route('news.index');
    }

   
    public function destroy(string $id)
    {
        $news = News::findOrFail($id);

        $this->authorize('delete', $news);

        if ($news->image_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($news->image_path);
        }
        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'Đã xóa bài viết.');
    }

    // --- Moderation Methods ---

    public function adminIndex()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $news = News::with(['user', 'category'])
            ->whereIn('status', ['pending', 'resubmitted'])
            ->latest()
            ->paginate(15);
        return view('admin.news.index', compact('news'));
    }

    public function adminApprovedIndex()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $news = News::with(['user', 'category'])
            ->where('status', 'approved')
            ->latest()
            ->paginate(15);
        return view('admin.news.index', compact('news'));
    }

    public function myNews()
    {
        $news = News::where('user_id', auth()->id())
            ->with('category')
            ->latest()
            ->paginate(10);
        
        return view('news.my_news', compact('news'));
    }

    public function approve($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $news = News::findOrFail($id);
        $news->update(['status' => 'approved']);

        // Gửi thông báo cho tất cả người dùng (trừ người viết bài?)
        // Thông thường là gửi cho tất cả người dùng
        $users = User::where('id', '!=', $news->user_id)->get();
        Notification::send($users, new NewNewsNotification($news));

        return redirect()->back()->with('success', 'Bài viết đã được duyệt và thông báo đã được gửi.');
    }

    public function reject(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'admin_note' => 'required|string|max:1000',
        ]);

        $news = News::findOrFail($id);
        $news->update([
            'status' => 'rejected',
            'admin_note' => $request->admin_note
        ]);

        return redirect()->back()->with('success', 'Bài viết đã bị từ chối với góp ý.');
    }

    public function toggleHot($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $news = News::findOrFail($id);
        $news->update(['is_hot' => !$news->is_hot]);

        $statusText = $news->is_hot ? 'đã được đặt làm tin nóng.' : 'đã bỏ đánh dấu tin nóng.';
        return redirect()->back()->with('success', "Bài viết {$statusText}");
    }
}
