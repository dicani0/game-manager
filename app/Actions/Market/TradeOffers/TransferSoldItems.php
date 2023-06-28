<?php

namespace App\Actions\Market\TradeOffers;

use App\Models\Market\TradeOffer;

class TransferSoldItems
{
    public function handle(TradeOffer $tradeOffer): void
    {
        $tradeOffer->creator->items()->attach($tradeOffer->items->map(function ($item) {
            return [
                'item_id' => $item->getKey(),
                'bought_amount' => $item->pivot->amount,
            ];
        })->toArray());
    }
}
