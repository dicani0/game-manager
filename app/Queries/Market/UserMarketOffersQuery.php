<?php

namespace App\Queries\Market;

use App\Enums\MarketOfferStatusEnum;
use App\Models\Market\MarketOffer;
use Auth;
use Spatie\QueryBuilder\QueryBuilder;

class UserMarketOffersQuery
{
    public function handle(): QueryBuilder
    {
        return QueryBuilder::for(MarketOffer::class)
            ->orderBy('promoted', 'desc')
            ->where('user_id', Auth::user()->getKey())
//            ->where('status', MarketOfferStatusEnum::ACTIVE->value)
            ->with(['items.cosmetic', 'user', 'offers.creator', 'offers.cosmetics']);
    }
}
