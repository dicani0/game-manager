<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Character\CharacterController;
use App\Http\Controllers\Cosmetics\CosmeticController;
use App\Http\Controllers\Guild\GuildController;
use App\Http\Controllers\Items\ItemController;
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

Route::prefix('guild')->group(function () {
    Route::get('/', [GuildController::class, 'dashboard']);
});

Route::get('/market', function () {
    return Inertia::render('Market/Market');
});
Route::prefix('characters')->middleware('auth')->group(function () {
    Route::get('/', [CharacterController::class, 'index']);
    Route::get('/create', [CharacterController::class, 'create']);
    Route::post('/', [CharacterController::class, 'store'])->middleware('auth');
    Route::get('/edit/{character}', [CharacterController::class, 'edit']);
    Route::put('/{character}', [CharacterController::class, 'update']);
    Route::delete('/{character}', [CharacterController::class, 'delete']);
});

Route::prefix('items')->middleware('auth')->group(function () {
    Route::get('/', [ItemController::class, 'index']);
    Route::post('/import', [ItemController::class, 'sync']);
    Route::put('/{item}', [ItemController::class, 'update']);
    Route::delete('/{item}', [ItemController::class, 'delete']);
});

Route::prefix('cosmetics')->group(function () {
    Route::get('/', [CosmeticController::class, 'index']);
});

Route::prefix('auth')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::inertia('register', 'Auth/Register')->name('register');
        Route::inertia('login', 'Auth/Login')->name('login');

        Route::post('register', RegisterController::class);
        Route::post('login', LoginController::class);
    });

    Route::middleware('auth')->group(function () {
        Route::get('profile', ProfileController::class);
        Route::get('logout', LogoutController::class);
    });
});
