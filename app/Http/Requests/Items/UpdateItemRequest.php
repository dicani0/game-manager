<?php

namespace App\Http\Requests\Items;

class UpdateItemRequest extends ItemRequest
{
    public function authorize(): bool
    {
        return $this->getUserItem()->user_id === $this->user()->getKey();
    }

    public function rules(): array
    {
        return [
            'sold_amount' => ['required', 'numeric', 'min:0', 'max:9999999999'],
            'used_amount' => ['required', 'numeric', 'min:0', 'max:9999999999'],
            'amount' => [
                'required',
                'numeric',
                'min:0',
                'max:9999999999',
                function (string $attribute, mixed $value, callable $fail): void {
                    if ($value < $this->get('sold_amount') + $this->get('used_amount')) {
                        $fail('Total amount must be greater than or equal to sold amount + used amount.');
                    }
                }],
        ];
    }
}
