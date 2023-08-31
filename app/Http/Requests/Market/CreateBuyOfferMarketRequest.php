<?php

namespace App\Http\Requests\Market;

class CreateBuyOfferMarketRequest extends CreateBuyOfferRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $offer = $this->route('offer');

        return !$offer->user->is($this->user());
    }
}
