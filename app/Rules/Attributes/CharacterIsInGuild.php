<?php

namespace App\Rules\Attributes;

use App\Models\Guild\Guild;
use App\Rules\Guild\CharacterIsInGuild as CharacterIsInGuildRule;
use Attribute;
use Spatie\LaravelData\Attributes\Validation\CustomValidationAttribute;
use Spatie\LaravelData\Support\Validation\ValidationPath;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class CharacterIsInGuild extends CustomValidationAttribute
{
    public function getRules(ValidationPath $path): array|object|string
    {
        $guild = request()->route('guild');

        assert($guild instanceof Guild);

        return [new CharacterIsInGuildRule($guild)];
    }
}
