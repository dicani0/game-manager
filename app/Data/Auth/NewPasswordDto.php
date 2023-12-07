<?php

namespace App\Data\Auth;

class NewPasswordDto extends NewPasswordFormDto
{
    public string $password;

    public string $password_confirmation;
}
