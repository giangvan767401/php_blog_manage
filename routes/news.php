<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use	App\Http\Controllers\HomeController;	
use App\Http\Controllers\CommentController;



// Route::get('/',	[HomeController::class,	'index'])->name('home');

Route::get('/', function () {
    return redirect()->route('news.index');
})->name('home');

Route::post('news/{news}/comments', [CommentController::class, 'store'])->middleware('auth')->name('news.comments.store');

// Route công khai (ai cũng truy cập được: xem danh sách và chi tiết tin tức)
Route::get('/news', [NewsController::class, 'index'])->name('news.index');

Route::middleware(['auth'])->group(function () {
    Route::get('news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('news', [NewsController::class, 'store'])->name('news.store');
    Route::get('my-news', [NewsController::class, 'myNews'])->name('news.my');
    
    // Sửa/Cập nhật/Xóa bài viết (sẽ check quyền sở hữu trong Controller)
    Route::get('/news/{id}/edit', [NewsController::class, 'edit'])->name('news.edit');
    Route::put('/news/{id}', [NewsController::class, 'update'])->name('news.update');
    Route::delete('/news/{id}', [NewsController::class, 'destroy'])->name('news.destroy');
});

Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');

// Route chỉ dành cho Admin (Duyệt bài, quản lý Category)
Route::middleware(['auth','check.admin'])->group(function () {
    Route::get('/admin/news', [NewsController::class, 'adminIndex'])->name('admin.news.index');
    Route::get('/admin/news/approved', [NewsController::class, 'adminApprovedIndex'])->name('admin.news.approved');
    Route::post('/admin/news/{id}/approve', [NewsController::class, 'approve'])->name('admin.news.approve');
    Route::post('/admin/news/{id}/reject', [NewsController::class, 'reject'])->name('admin.news.reject');
    Route::post('/admin/news/{id}/toggle-hot', [NewsController::class, 'toggleHot'])->name('admin.news.toggle-hot');
    
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
});

