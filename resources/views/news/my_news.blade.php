@extends('layouts.myapp')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Bài viết của tôi</h1>
        @can('create', App\Models\News::class)
            <a href="{{ route('news.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition duration-150 ease-in-out">
                + Viết bài mới
            </a>
        @endcan
    </div>


    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tiêu đề</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Danh mục</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày tạo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Hành động</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($news as $item)
                <tr>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $item->title }}</div>
                        @if($item->status === 'rejected' && $item->admin_note)
                            <div class="mt-1 p-2 bg-red-50 border border-red-100 rounded text-xs text-red-600">
                                <strong>Góp ý từ Admin:</strong> {{ $item->admin_note }}
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">{{ $item->category->name ?? 'Không xác định' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">{{ $item->created_at->format('d/m/Y') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $item->status === 'approved' ? 'bg-green-100 text-green-800' : 
                               ($item->status === 'rejected' ? 'bg-red-100 text-red-800' : 
                               ($item->status === 'resubmitted' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800')) }}">
                            @if($item->status === 'pending') Chờ duyệt
                            @elseif($item->status === 'approved') Đã đăng
                            @elseif($item->status === 'rejected') Yêu cầu sửa đổi
                            @elseif($item->status === 'resubmitted') Đã cập nhật (đang chờ duyệt)
                            @endif
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <a href="{{ route('news.show', $item->id) }}" class="text-indigo-600 hover:text-indigo-900" target="_blank">Xem</a>
                        
                        @if($item->status !== 'approved')
                            <a href="{{ route('news.edit', $item->id) }}" class="text-blue-600 hover:text-blue-900">Sửa</a>
                        @endif

                        <form action="{{ route('news.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Xóa</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Bạn chưa có bài viết nào.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $news->links() }}
    </div>
</div>
@endsection
