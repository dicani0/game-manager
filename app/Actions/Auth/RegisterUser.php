<?php

namespace App\Actions\Auth;

use App\Data\Auth\RegisterUserDto;
use App\Models\User;
use Closure;

final class RegisterUser
{
    public function handle(RegisterUserDto $dto, Closure $next): User
    {
        return $next(User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => bcrypt($dto->password),
        ]));
    }
}
