<?php

use App\Http\Controllers\AuthController;
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

Route::get('user/register',[AuthController::class,"create"]);
Route::post('user/register',[AuthController::class,"store"])->name("auth.register");

Route::get('/', function () {
    return view('auth.login');
});

Route::get('user/profile', function () {
    return view('main.profile');
});

Route::get('/edit-profile', function () {
    return view('main.edit_profile');
});
