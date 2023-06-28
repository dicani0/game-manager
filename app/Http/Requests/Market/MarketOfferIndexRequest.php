<?php

namespace App\Http\Requests\Market;

use Illuminate\Foundation\Http\FormRequest;

class MarketOfferIndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'seller' => ['nullable', 'exists:users,id'],
            'item' => ['nullable'],
            'at_price' => ['nullable', 'numeric'],
            'lat_price' => ['nullable', 'numeric'],
        ];
    }
}
