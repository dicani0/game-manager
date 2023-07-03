<?php

namespace App\Queries\Market;

use App\Enums\MarketOfferStatusEnum;
use App\Models\Market\MarketOffer;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class UserMarketOffersQuery
{
    public function handle(): QueryBuilder
    {
        return QueryBuilder::for(MarketOffer::class)
            ->orderBy('promoted', 'desc')
            ->where('user_id', Auth::id())
            ->where('status', MarketOfferStatusEnum::ACTIVE->value)
            ->with(['items.item', 'user', 'offers.creator', 'offers.items']);
    }
}