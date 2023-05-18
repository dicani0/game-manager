<?php

namespace App\Actions\Auth;

use App\Data\LoginUserDto;
use App\Exceptions\Auth\InvalidCredentialsException;
use App\Models\User;
use Closure;

final class LoginUser
{
    /**
     * @throws InvalidCredentialsException
     */
    public function handle(LoginUserDto $dto): void
    {
        if (!auth()->attempt($dto->toArray())) {
            throw new InvalidCredentialsException();
        }
            request()->session()->regenerate();
    }
}
