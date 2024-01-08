<?php

namespace App\Rules\Poll;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Translation\PotentiallyTranslatedString;

readonly class PollableModelExists implements ValidationRule
{
    public function __construct(private ?string $class)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param  Closure(string): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_subclass_of($this->class, Model::class)) {
            $fail('Wrong pollable type');
        }

        $this->class::query()->findOr($value, fn () => $fail("{$this->class} not found"));
    }
}
