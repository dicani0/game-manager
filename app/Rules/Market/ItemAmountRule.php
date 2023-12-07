<?php

namespace App\Rules\Market;

use Auth;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ItemAmountRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $item = Auth::user()->items()->where('item_id', $value['item_id'])->first();

        if ($item === null) {
            $fail('You do not own this item');
        }

        if ($item->pivot->available_amount < $value['amount']) {
            $fail('You do not have enough of this item:'.$item->name);
        }
    }
}
