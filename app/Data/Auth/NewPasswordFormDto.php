<?php

namespace App\Data\Auth;

use Spatie\LaravelData\Data;

class NewPasswordFormDto extends Data
{
    public string $email;

    public string $token;
}
