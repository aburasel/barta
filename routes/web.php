<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
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

Route::middleware(["guest"])->group(function () {

    Route::get('user/register', [RegisterController::class, "create"]);
    Route::post('user/register', [RegisterController::class, "store"])->name("auth.register");
    
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'postLogin'])->name('auth.login');
});

Route::middleware(["auth"])->group(function () {
    Route::get('/logout', [LoginController::class, "logOut"])->name("auth.logout");
    Route::get('user/profile/{id}', [ProfileController::class, "profile"])->name("profile");
    Route::get('user/edit-profile', [ProfileController::class, "create"])->name("profile.edit");
    Route::post('user/profile', [ProfileController::class, "store"])->name("profile.post");
    
    Route::get('/', [PostController::class, "index"])->name("dashboard");
    Route::post('feed/', [PostController::class, "store"])->name("feed.post");
});