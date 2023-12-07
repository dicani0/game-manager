<?php

namespace App\Actions\Auth;

use App\Data\Auth\LoginUserDto;
use App\Exceptions\Auth\EmailNotVerifiedException;
use App\Exceptions\Auth\InvalidCredentialsException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

final class LoginUser
{
    /**
     * @throws InvalidCredentialsException
     * @throws EmailNotVerifiedException
     */
    public function handle(LoginUserDto $dto): void
    {
        $user = User::query()->whereEmail($dto->email)->first();

        if (! $user) {
            throw new InvalidCredentialsException();
        }

        $this->ensureCredentialsAreValid($user, $dto->password);
        $this->ensureUserIsVerified($user);
        $this->loginUser($user);
    }

    /**
     * @throws EmailNotVerifiedException
     */
    private function ensureUserIsVerified(User $user): void
    {
        if (! $user->hasVerifiedEmail()) {
            throw new EmailNotVerifiedException();
        }
    }

    /**
     * @throws InvalidCredentialsException
     */
    private function ensureCredentialsAreValid(User $user, string $password): void
    {
        if (! Hash::check($password, $user->password)) {
            throw new InvalidCredentialsException();
        }
    }

    private function loginUser(User $user): void
    {
        auth()->login($user);
        request()->session()->regenerate();
    }
}
