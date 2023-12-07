<?php

namespace App\Data\Character;

use App\Enums\VocationEnum;
use Illuminate\Support\Facades\Gate;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\References\RouteParameterReference;

class CharacterUpdateDto extends Data
{
    #[Required, Min(3), Max(20), StringType, Unique('characters', 'name', ignore: new RouteParameterReference('character', 'id'))]
    public string $name;

    #[Required, Enum(VocationEnum::class)]
    public string $vocation;

    public static function authorize(): bool
    {
        return Gate::allows('edit', request('character'));
    }
}
