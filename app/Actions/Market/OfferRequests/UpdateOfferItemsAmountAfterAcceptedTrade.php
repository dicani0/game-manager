<?php

namespace App\Actions\Market\OfferRequests;

use App\Models\Market\MarketOffer;
use App\Models\Market\MarketOfferItem;
use App\Models\Market\OfferRequest;

class UpdateOfferItemsAmountAfterAcceptedTrade
{
    public function handle(OfferRequest $request): void
    {
        if ($request->offerable instanceof MarketOffer) {
            $cosmeticsInRequest = $request->cosmetics->keyBy('id');
            $request->offerable->items->each(function (MarketOfferItem $item) use ($request, $cosmeticsInRequest) {
                if ($cosmeticsInRequest->has($item->cosmetic_id)) {
                    $newAmount = $item->amount - $cosmeticsInRequest[$item->cosmetic_id]->pivot->amount;
                    if ($newAmount <= 0) {
                       $request->offerable->items()->where('cosmetic_id', $item->cosmetic_id)->delete();
                    } else {
                        $item->amount = $newAmount;
                        $item->save();
                    }
                }
            });
        }
    }
}
