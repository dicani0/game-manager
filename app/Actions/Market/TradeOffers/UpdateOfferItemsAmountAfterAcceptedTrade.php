<?php

namespace App\Actions\Market\TradeOffers;

use App\Models\Market\MarketOffer;
use App\Models\Market\MarketOfferItem;
use App\Models\Market\TradeOffer;

class UpdateOfferItemsAmountAfterAcceptedTrade
{
    public function handle(TradeOffer $tradeOffer): void
    {
        if ($tradeOffer->offerable instanceof MarketOffer) {
            $itemsInRequest = $tradeOffer->items->keyBy('id');
            $tradeOffer->offerable->items->each(function (MarketOfferItem $item) use ($tradeOffer, $itemsInRequest) {
                if ($itemsInRequest->has($item->item_id)) {
                    $newAmount = $item->amount - $itemsInRequest[$item->item_id]->pivot->amount;
                    if ($newAmount <= 0) {
                       $tradeOffer->offerable->items()->where('item_id', $item->item_id)->delete();
                    } else {
                        $item->amount = $newAmount;
                        $item->save();
                    }
                }
            });
        }
    }
}
