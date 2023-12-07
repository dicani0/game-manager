<?php

namespace App\Http\Requests\Market;

use App\Models\Market\MarketOffer;

class CreateBuyOfferMarketRequest extends CreateBuyOfferRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /** @var MarketOffer $offer */
        $offer = $this->route('offer');

        return !$offer->user->is($this->user());
    }
}
