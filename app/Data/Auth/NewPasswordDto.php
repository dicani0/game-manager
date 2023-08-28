<?php

namespace App\Data\Auth;

use Spatie\LaravelData\Data;

class NewPasswordDto extends NewPasswordFormDto
{
    public string $password;
    public string $password_confirmation;
}
