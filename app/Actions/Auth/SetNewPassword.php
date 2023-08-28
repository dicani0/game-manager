<?php

namespace App\Actions\Auth;

use App\Data\Auth\NewPasswordDto;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

final class SetNewPassword
{
    public function handle(NewPasswordDto $dto): string
    {
        return Password::reset($dto->toArray(), function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password),
            ])->save();
        });
    }
}
