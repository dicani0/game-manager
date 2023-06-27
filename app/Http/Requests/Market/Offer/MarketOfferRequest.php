<?php

namespace App\Http\Requests\Market\Offer;

use App\Models\Market\MarketOffer;
use App\Models\Market\OfferRequest;
use Illuminate\Foundation\Http\FormRequest;

class MarketOfferRequest extends FormRequest
{
    public function rules(): array
    {
        return [];
    }

    protected function getOfferRequest(): OfferRequest
    {
        return $this->route('offerRequest');
    }

    protected function getMarketOffer(): MarketOffer
    {
        return $this->route('offer');
    }
}
