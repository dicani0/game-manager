<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{userId}', function ($user, $userId) {
    return (int)$user->id === (int)$userId;
});
Broadcast::channel('trade-offer.{userId}', function (User $user, int $userId) {
    return $user->getKey() === $userId;
});
Broadcast::channel('guild-invite.{userId}', function (User $user, int $userId) {
    return $user->getKey() === $userId;
});
Broadcast::channel('guild.{guildId}', function (User $user, int $guildId) {
    return $user->guilds->pluck('id')->contains($guildId);
});

