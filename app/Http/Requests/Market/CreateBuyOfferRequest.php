<?php

namespace App\Http\Requests\Market;

use Illuminate\Foundation\Http\FormRequest;

class CreateBuyOfferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $offer = $this->route('offer');

        return !$offer->user->is($this->user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'lat_price' => ['required', 'numeric', 'min:0'],
            'at_price' => ['required', 'numeric', 'min:0'],
            'message' => ['nullable', 'string', 'max:255'],
            'items' => ['required', 'array'],
            'items.*.id' => ['required', 'numeric', 'exists:cosmetics,id'],
            'items.*.amount' => ['required', 'numeric', 'min:1'],
        ];
    }
}
