<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use	App\Http\Controllers\HomeController;	
use App\Http\Controllers\CommentController;



Route::get('/',	[HomeController::class,	'index'])->name('home');

Route::get('/', function () {
    return redirect()->route('news.index');
})->name('home');

Route::post('news/{news}/comments', [CommentController::class, 'store'])->middleware('auth')->name('news.comments.store');

// Route công khai (ai cũng truy cập được: xem danh sách và chi tiết tin tức)
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');

// Route yêu cầu đăng nhập (chỉ user đã auth mới thêm/sửa/xóa)
Route::middleware(['auth','check.admin'])->group(function () {
    Route::get('/news/{id}/edit', [NewsController::class, 'edit'])->name('news.edit');
    Route::put('/news/{id}', [NewsController::class, 'update'])->name('news.update');
    Route::delete('/news/{id}', [NewsController::class, 'destroy'])->name('news.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('news', [NewsController::class, 'store'])->name('news.store');
});