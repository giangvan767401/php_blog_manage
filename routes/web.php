<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/notifications/{id}/mark-as-read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::post('/notifications/mark-all-as-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');

    // Writer Request
    Route::post('/request-writer', [\App\Http\Controllers\AdminUserController::class, 'requestWriter'])->name('writer.request');
});

// Admin Routes for Writer Management
Route::middleware(['auth', 'check.admin'])->group(function () {
    Route::get('/admin/writers', [\App\Http\Controllers\AdminUserController::class, 'writersIndex'])->name('admin.writers.index');
    Route::post('/admin/writer-requests/{id}/approve', [\App\Http\Controllers\AdminUserController::class, 'approveWriter'])->name('admin.writer.approve');
    Route::post('/admin/writer-requests/{id}/reject', [\App\Http\Controllers\AdminUserController::class, 'rejectWriter'])->name('admin.writer.reject');
    Route::post('/admin/writers/{id}/demote', [\App\Http\Controllers\AdminUserController::class, 'demoteWriter'])->name('admin.writers.demote');
});

require __DIR__.'/auth.php';
require __DIR__.'/news.php';
