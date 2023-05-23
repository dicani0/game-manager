<?php

use App\Enums\VocationEnum;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Character\CharacterController;
use App\Http\Controllers\Guild\GuildController;
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

    Route::get('/', function () {
        return Inertia::render('Character/Character', [
            'characters' => request()->user()->characters,
        ]);
    });

    Route::get('/create', function () {
        return Inertia::render('Character/Create', [
            'vocations' => VocationEnum::getValues(),
        ]);
    });
    Route::post('/', [CharacterController::class, 'store']);

    Route::get('/edit/{character}', function () {
        return Inertia::render('Character/Edit', [
            'character' => \App\Models\Character\Character::find(request()->route('character')),
            'vocations' => VocationEnum::getValues(),
        ]);
    });

    Route::delete('/{character}', [CharacterController::class, 'delete']);
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
