<?php

use App\Http\Controllers\CommonController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/users', [CommonController::class, 'user'])->name('user');
    Route::get('/blog', [CommonController::class, 'blog'])->name('blog');
    Route::get('/blog_update', [CommonController::class, 'blog_update'])->name('blog');
    Route::post('/blog/store', [CommonController::class, 'store']);
    Route::delete('/delete-blog/{id}', [CommonController::class, 'destroy'])->name('blog.destroy');

});

require __DIR__.'/auth.php';
