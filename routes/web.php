<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
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

Route::get('user/register', [AuthController::class, "createRegister"]);
Route::post('user/register', [AuthController::class, "storeRegister"])->name("auth.register");
Route::get('/logout', [AuthController::class, "logOut"])->name("auth.logout");

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/post-login', [AuthController::class, 'postLogin'])->name('auth.login');

Route::get('user/profile', [ProfileController::class, "profile"])->name("profile");
Route::get('user/edit-profile', [ProfileController::class, "create"])->name("profile.edit");
Route::post('user/profile', [ProfileController::class, "store"])->name("profile.post");

Route::get('/', [AppController::class, "index"])->name("dashboard");
