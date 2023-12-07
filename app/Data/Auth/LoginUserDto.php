<?php

namespace App\Data\Auth;

use Spatie\LaravelData\Data;

class LoginUserDto extends Data
{
    public string $email;

    public string $password;
}
