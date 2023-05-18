<?php

namespace App\Actions\Auth;

use App\Data\RegisterUserDto;
use App\Exceptions\Auth\InvalidCredentialsException;
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
