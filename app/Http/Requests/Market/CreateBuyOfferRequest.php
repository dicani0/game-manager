<?php

namespace App\Http\Requests\Market;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

abstract class CreateBuyOfferRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'lat_price' => ['required', 'numeric', 'min:0'],
            'at_price' => ['required', 'numeric', 'min:0'],
            'message' => ['nullable', 'string', 'max:255'],
            'items' => ['required', 'array'],
            'items.*.id' => ['required', 'numeric', 'exists:items,id'],
            'items.*.amount' => ['required', 'numeric', 'min:1'],
        ];
    }
}
