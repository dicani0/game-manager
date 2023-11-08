<?php

namespace App\Http\Requests\Market\Offer;

use App\Models\Interfaces\Offerable;
use App\Models\Market\TradeOffer;
use Illuminate\Foundation\Http\FormRequest;

class MarketOfferRequest extends FormRequest
{
    public function rules(): array
    {
        return [];
    }

    protected function getOfferRequest(): TradeOffer
    {
        return $this->route('offerRequest');
    }

    protected function getOfferable(): Offerable
    {
        return $this->getOfferRequest()->offerable;
    }
}
