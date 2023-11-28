<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SettingsController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Character\CharacterController;
use App\Http\Controllers\Guild\GuildController;
use App\Http\Controllers\Guild\GuildInvitationController;
use App\Http\Controllers\Items\ItemController;
use App\Http\Controllers\Items\UserItemController;
use App\Http\Controllers\Market\MarketController;
use App\Http\Controllers\Market\MarketOfferRequestController;
use App\Http\Controllers\Market\TradeOfferController;
use App\Http\Controllers\Notifications\NotificationController;
use Illuminate\Support\Facades\Route;

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
Route::inertia('/', 'Home')->name('home');
Route::inertia('/about', 'About')->name('about');

Route::prefix('market')->group(function () {
    Route::get('/', [MarketController::class, 'index']);
    Route::middleware('auth')->group(function () {
        Route::get('/requests', [TradeOfferController::class, 'index']);
        //trade requests
        Route::post('/user/{user}/buy', [MarketController::class, 'createBuyOfferUser']);
        Route::post('/{offer}/buy', [MarketController::class, 'createBuyOfferMarket']);
        //market offers
        Route::get('/my', [MarketController::class, 'userOffers']);
        Route::get('/history', [MarketController::class, 'history']);
        Route::post('/', [MarketController::class, 'store']);
        Route::delete('/{offer}', [MarketController::class, 'cancel']);

        Route::post('/{offerRequest}/{offer}/accept', [MarketOfferRequestController::class, 'accept']);
        Route::post('/{offerRequest}/{offer}/reject', [MarketOfferRequestController::class, 'reject']);
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

Route::prefix('guilds')->middleware('auth')->group(function () {

    Route::prefix('invites')->group(function () {
        Route::get('/', [GuildInvitationController::class, 'invites']);

        Route::post('/{guildInvitation}/accept', [GuildInvitationController::class, 'accept']);
        Route::post('/{guildInvitation}/reject', [GuildInvitationController::class, 'reject']);
        Route::post('/{guildInvitation}/cancel', [GuildInvitationController::class, 'cancel']);
    });


    Route::post('/{guild}/invite/{character}', [GuildInvitationController::class, 'invite']);

    Route::get('/', [GuildController::class, 'index']);
    Route::get('/create', [GuildController::class, 'create']);
    Route::delete('/{guild}/kick/{member}', [GuildController::class, 'kick']);
    Route::get('/{guild:name}', [GuildController::class, 'show']);
    Route::post('/', [GuildController::class, 'store']);
    Route::patch('/{guild}', [GuildController::class, 'update']);
});

Route::prefix('auth')->group(function () {
    Route::get('email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');
    Route::get('users', [UserController::class, 'getPublicUsers']);
    Route::middleware('guest')->group(function () {
        Route::inertia('register', 'Auth/Register')->name('register');
        Route::get('login', [LoginController::class, 'loginForm'])->name('login');
        Route::post('register', RegisterController::class);
        Route::post('login', [LoginController::class, 'login'])->middleware('failed-logins:5,1');

        Route::inertia('forgot-password', 'Auth/ForgotPassword')->name('password.request');
        Route::post('forgot-password', ResetPasswordController::class)->name('password.email');
        Route::get('/reset-password/{token}', [NewPasswordController::class, 'get'])->name('password.reset');
        Route::post('/reset-password', [NewPasswordController::class, 'post'])->name('password.update');

        Route::inertia('resend-verification', 'Auth/ResendVerificationEmail')->name('verification.resend');


    });

    Route::middleware('auth')->group(function () {
        Route::get('profile', ProfileController::class);
        Route::get('logout', LogoutController::class);
        Route::get('settings', [SettingsController::class, 'get']);
        Route::patch('settings', [SettingsController::class, 'patch']);
    });
});

Route::prefix('notifications')->middleware('auth')->group(function () {
    Route::get('/all', [NotificationController::class, 'notifications']);
    Route::get('/{notification}/read', [NotificationController::class, 'readNotification']);
});
