<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Home');
});
Route::get('/about', function () {
    return Inertia::render('About');
});
Route::prefix('auth')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::inertia('register', 'Auth/Register')->name('register');
        Route::inertia('login', 'Auth/Login')->name('login');

        Route::post('register', RegisterController::class);
        Route::post('login', LoginController::class);
    });

    Route::middleware('auth')->group(function () {
        Route::get('logout', LogoutController::class);
    });
});
