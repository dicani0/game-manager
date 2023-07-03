<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Character\CharacterController;
use App\Http\Controllers\Items\ItemController;
use App\Http\Controllers\Guild\GuildController;
use App\Http\Controllers\Items\UserItemController;
use App\Http\Controllers\Market\MarketController;
use App\Http\Controllers\Market\MarketOfferRequestController;
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

Route::prefix('market')->group(function () {
    Route::get('/', [MarketController::class, 'index']);
    Route::middleware('auth')->group(function () {
        //trade requests
        Route::post('/{offer}/buy', [MarketController::class, 'createBuyOffer']);
        //market offers
        Route::get('/my', [MarketController::class, 'userOffers']);
        Route::post('/', [MarketController::class, 'store']);
        Route::delete('/{offer}', [MarketController::class, 'cancel']);

        Route::post('/{offer}/{offerRequest}/accept', [MarketOfferRequestController::class, 'accept']);
        Route::post('/{offer}/{offerRequest}/reject', [MarketOfferRequestController::class, 'reject']);
    });
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
    Route::get('/my', [UserItemController::class, 'index']);
    Route::post('/import', [UserItemController::class, 'sync']);
    Route::put('/{item}', [UserItemController::class, 'update']);
    Route::delete('/{item}', [UserItemController::class, 'delete']);

    Route::get('/', [ItemController::class, 'index']);
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
