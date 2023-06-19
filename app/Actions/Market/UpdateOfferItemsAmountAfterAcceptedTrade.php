<?php

namespace App\Actions\Market;

use App\Enums\MarketOfferRequestStatusEnum;
use App\Models\Market\MarketOffer;
use App\Models\Market\MarketOfferItem;
use App\Models\Market\OfferRequest;

class UpdateOfferItemsAmountAfterAcceptedTrade
{
    public function handle(OfferRequest $request): void
    {
        if ($request->offerable instanceof MarketOffer) {
            $cosmeticsInRequest = $request->cosmetics->keyBy('id');

            $request->offerable->items->each(function (MarketOfferItem $item) use ($cosmeticsInRequest) {
                if ($cosmeticsInRequest->has($item->cosmetic_id)) {
                    $item->amount -= $cosmeticsInRequest[$item->cosmetic_id]->pivot->amount;
                    $item->save();
                }
            });
        }
    }
}
