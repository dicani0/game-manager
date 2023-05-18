<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class RegisterUserDto extends Data
{
    public string $name;
    public string $email;
    public string $password;
}
