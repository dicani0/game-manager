<?php

namespace App\Actions\Market;

use App\Jobs\Market\SetMarketOfferStatusAsExpired;
use App\Models\Market\MarketOffer;

class SetMarketOfferAsExpired
{
    public function handle(MarketOffer $marketOffer): void
    {
        SetMarketOfferStatusAsExpired::dispatch($marketOffer)->delay($marketOffer->expires_at);
    }
}
