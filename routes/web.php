<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostControllerTest;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileSearchController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    //Route::get('/', [PostController::class, 'index'])->name('dashboard');
    Route::get('/', [PostControllerTest::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('profile/{id}', [ProfileController::class, 'profile'])->name('profile');

    Route::post('/feed', [PostController::class, 'store'])->name('feed.post');
    Route::get('feed/hashtag/{key}', [PostController::class, 'postByTags'])->name('feed.tags');
    Route::get('feed/single/{key}', [PostController::class, 'viewPostByUUID'])->name('feed.single');
    Route::get('feed/edit-post/{key}', [PostController::class, 'editPostByUUID'])->name('post.edit');
    Route::post('feed/edit/{key}', [PostController::class, 'storePostByUUID'])->name('post.edit.store');
    Route::get('feed/delete-post/{key}', [PostController::class, 'delete'])->name('post.delete');

    Route::post('profile/search/', [ProfileSearchController::class, 'searchProfile'])->name('profile.search');

    Route::post('/comment', [CommentController::class, 'store'])->name('comment');
});

require __DIR__.'/auth.php';
