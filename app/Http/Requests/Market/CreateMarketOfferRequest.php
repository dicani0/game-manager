<?php

namespace App\Http\Requests\Market;

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
            'items.*.cosmetic_id' => ['required', 'exists:cosmetics,id', function ($attribute, $value, $fail) {
                $cosmetic = $this->user()->cosmetics()->where('cosmetic_id', $value)->first();
                if ($cosmetic->pivot->available_amount < $this->input('items.*.amount')[0]) {
                    $fail('You do not have enough cosmetics to create this offer with item ' . $cosmetic->name);
                }
            }],
            'items.*.amount' => ['required', 'integer', 'min:1'],
            'promoted' => ['nullable', 'boolean'],
        ];
    }
}
