<?php

namespace App\Http\Requests\Market;

use App\Rules\Market\ItemAmountRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateMarketOfferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'items' => ['required', 'array'],
            'items.*.item_id' => ['required', 'exists:items,id'],
            'items.*.amount' => ['required', 'integer', 'min:1'],
            'items.*' => [new ItemAmountRule],
            'promoted' => ['nullable', 'boolean', function ($attribute, $value, $fail) {
                if ($value && $this->user()->available_promotes < 1) {
                    $fail('You do not have enough promotes to create a promoted offer');
                }
            }],
        ];
    }
}
