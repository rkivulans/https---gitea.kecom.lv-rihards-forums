<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\AdminForumController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MusicController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




Route::middleware('auth')->group(function () {
    Route::resource('forum.comment', CommentController::class)->only(['store','destroy','edit','update']);

    Route::resource('music', MusicController::class)->only(['index', 'store', 'create']);

    Route::resource('adminforum', AdminForumController::class);

    Route::delete('adminforum/user/{id}', [AdminForumController::class, 'deleteUser'])->name('adminforum.deleteUser');
    Route::patch('adminforum/user/{id}', [AdminForumController::class, 'blockUser'])->name('adminforum.blockUser');

    Route::delete('adminforum/music/{id}', [AdminForumController::class, 'deleteMusic'])->name('adminforum.deleteMusic');

});

Route::get('/news', [NewsController::class, 'index'])->name('news');
Route::resource('forum', ForumController::class)->only(['store','create','index','show']);

require __DIR__.'/auth.php';
