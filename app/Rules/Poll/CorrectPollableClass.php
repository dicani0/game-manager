<?php

namespace App\Rules\Poll;

use App\Models\Interfaces\Pollable;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class CorrectPollableClass implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_null($value)) {
            return;
        }

        if (! class_exists($value)) {
            $fail('Wrong poll type');
        }

        if (! is_subclass_of($value, Pollable::class)) {
            $fail('Wrong poll type');
        }
    }
}
