<?php

namespace App\Data\Auth;

use App\Casts\HashCast;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class SettingsData extends Data
{
    public ?string $discord_name;

    public bool $private;

    #[WithCast(HashCast::class)]
    public string|Optional $password;
}
