<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;

class NotificationPolicy
{
    public function read(User $user, DatabaseNotification $notification): bool
    {
        return $user->id === $notification->notifiable_id;
    }
}
