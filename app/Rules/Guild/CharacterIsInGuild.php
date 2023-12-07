<?php

namespace App\Rules\Guild;

use App\Models\Guild\Guild;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class CharacterIsInGuild implements ValidationRule
{
    public function __construct(private Guild $guild)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param  Closure(string): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $this->guild->characters()->where('id', $value)->exists()) {
            $fail("The selected character is not in the {$this->guild->name} guild.");
        }
    }
}
