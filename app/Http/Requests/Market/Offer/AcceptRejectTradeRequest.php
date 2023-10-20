<?php

namespace App\Http\Requests\Market\Offer;

use App\Enums\MarketOfferRequestStatusEnum;
use Illuminate\Contracts\Validation\ValidationRule;

class AcceptRejectTradeRequest extends MarketOfferRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->getMarketOffer()->user->getKey() === $this->user()->getKey()
            && $this->getOfferRequest()->status === MarketOfferRequestStatusEnum::PENDING;
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
