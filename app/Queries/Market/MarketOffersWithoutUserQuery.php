<?php

namespace App\Queries\Market;

use App\Enums\MarketOfferStatusEnum;
use App\Models\Market\MarketOffer;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class MarketOffersWithoutUserQuery
{
    public function handle(): QueryBuilder
    {
        return QueryBuilder::for(MarketOffer::class)
            ->with(['items', 'items.item', 'user'])
            ->orderBy('promoted', 'desc')
            ->whereNot('user_id', Auth::id())
            ->where('status', MarketOfferStatusEnum::ACTIVE)
            ->allowedFilters([
                AllowedFilter::exact('seller', 'user_id'),
                AllowedFilter::scope('lat_price', 'maxLatPrice'),
                AllowedFilter::scope('at_price', 'maxAtPrice'),
                AllowedFilter::callback('item', fn ($query, $value) => $query->whereHas('items', fn ($query) => $query->whereHas('cosmetic', fn ($query) => $query->where('name', 'like', "%{$value}%")))),
            ]);
    }
}
