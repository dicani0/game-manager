<?php

namespace App\Actions\Market\Interfaces;

use App\Models\Market\TradeOffer;
use Illuminate\Support\Collection;

interface OfferableHandler
{
    public function handle(TradeOffer $tradeOffer, Collection $itemsInRequest): void;
}
