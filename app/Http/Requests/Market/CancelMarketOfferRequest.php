<?php

namespace App\Http\Requests\Market;

use App\Models\Market\MarketOffer;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CancelMarketOfferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /** @var MarketOffer $offer */
        $offer = $this->route('offer');
        
        return $offer->user->is($this->user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [];
    }
}
