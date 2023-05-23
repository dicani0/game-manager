<?php

namespace App\Actions\Auth;

use App\Data\Auth\LoginUserDto;
use App\Exceptions\Auth\InvalidCredentialsException;

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
