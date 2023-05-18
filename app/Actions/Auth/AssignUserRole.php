<?php

namespace App\Actions\Auth;

use App\Data\RegisterUserDto;
use App\Enums\RoleEnum;
use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Log;

final class AssignUserRole
{
    public function handle(User $user, Closure $next): User
    {
        $user->assignRole(RoleEnum::USER->value);

        return $next($user);
    }
}
