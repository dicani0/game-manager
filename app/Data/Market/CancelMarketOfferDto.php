<?php

namespace App\Data\Market;

use App\Models\Market\MarketOffer;
use App\Models\User;
use Spatie\LaravelData\Data;

class CancelMarketOfferDto extends Data
{
    public function __construct(
        public User        $user,
        public MarketOffer $offer,
    )
    {
    }
}
