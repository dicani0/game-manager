<?php

namespace App\Actions\Market\TradeOffers;

use App\Models\Items\Item;
use App\Models\Items\UserItem;
use App\Models\Market\TradeOffer;
use Auth;

class UpdateOfferCreatorItemsAfterAcceptingTrade
{
    public function handle(TradeOffer $tradeOffer): void
    {
        $tradeOffer->items->each(function (Item $item) {
            $query = UserItem::query()
                ->where('user_id', Auth::id())
                ->where('item_id', $item->getKey());

            $query->decrement('reserved_amount', $item->pivot->amount);
            $query->increment('sold_amount', $item->pivot->amount);
        });
    }
}
