<?php

namespace App\Data\Character;

use App\Enums\VocationEnum;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;

class CharacterDto extends Data
{
    #[Required, Min(3), Max(20), StringType, Unique('characters', 'name')]
    public string $name;

    #[Required, Enum(VocationEnum::class)]
    public string $vocation;
}
