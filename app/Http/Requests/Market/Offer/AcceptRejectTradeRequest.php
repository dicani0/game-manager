<?php

namespace App\Http\Requests\Market\Offer;

use App\Enums\MarketOfferRequestStatusEnum;
use App\Models\Market\MarketOffer;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;

class AcceptRejectTradeRequest extends MarketOfferRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $offerable = $this->getOfferRequest()->offerable;

        $condition = match (true) {
            $offerable instanceof MarketOffer => $offerable->user->getKey() === $this->user()->getKey(),
            $offerable instanceof User => $offerable->getKey() === $this->user()->getKey(),
            default => false,
        };

        return $condition && $this->getOfferRequest()->status === MarketOfferRequestStatusEnum::PENDING;
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
