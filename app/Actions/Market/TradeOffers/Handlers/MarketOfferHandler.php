<?php

namespace App\Actions\Market\TradeOffers\Handlers;

use App\Actions\Market\Interfaces\OfferableHandler;
use App\Models\Market\MarketOffer;
use App\Models\Market\MarketOfferItem;
use App\Models\Market\TradeOffer;
use Illuminate\Support\Collection;

class MarketOfferHandler implements OfferableHandler
{

    public function handle(TradeOffer $tradeOffer, Collection $itemsInRequest): void
    {
        assert($tradeOffer->offerable instanceof MarketOffer);
        $tradeOffer->offerable->items->each(function (MarketOfferItem $item) use ($tradeOffer, $itemsInRequest) {
            if ($itemsInRequest->has($item->item_id)) {
                $newAmount = $item->amount - $itemsInRequest[$item->item_id]->pivot->amount;
                if ($newAmount <= 0) {
                    assert($tradeOffer->offerable instanceof MarketOffer);
                    $tradeOffer->offerable->items()->where('item_id', $item->item_id)->delete();
                } else {
                    $item->amount = $newAmount;
                    $item->save();
                }
            }
        });
    }
}