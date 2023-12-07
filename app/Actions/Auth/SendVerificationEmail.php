<?php

namespace App\Actions\Auth;

use App\Models\User;
use Closure;

final class SendVerificationEmail
{
    public function handle(User $user, Closure $next): User
    {
        $user->sendEmailVerificationNotification();

        return $next($user);
    }
}
