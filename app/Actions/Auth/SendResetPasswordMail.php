<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Password;

final class SendResetPasswordMail
{
    public function handle(string $email): string
    {
        return Password::sendResetLink(['email' => $email]);
    }
}
