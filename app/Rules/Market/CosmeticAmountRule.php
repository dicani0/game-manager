<?php

namespace App\Rules\Market;

use Auth;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CosmeticAmountRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cosmetic = Auth::user()->cosmetics()->where('cosmetic_id', $value['cosmetic_id'])->first();

        if ($cosmetic === null) {
            $fail('You do not own this cosmetic');
        }

        if ($cosmetic->pivot->available_amount < $value['amount']) {
            $fail('You do not have enough of this cosmetic:' . $cosmetic->name);
        }
    }
}
