<?php

namespace App\Queries\Market;

use App\Models\Market\MarketOffer;
use App\Models\Market\TradeOffer;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\QueryBuilder;

class UserTradeOffersQuery
{
    public function handle(): QueryBuilder
    {
        return QueryBuilder::for(TradeOffer::class)
            ->whereHasMorph('offerable', [MarketOffer::class], function (Builder $query) {
                $query->where('user_id', auth()->id());
            })
            ->orWhereHasMorph('offerable', [User::class], function (Builder $query) {
                $query->where('id', auth()->id());
            })
            ->orderBy('created_at', 'desc');
    }
}
