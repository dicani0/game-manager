<?php

namespace App\Actions\Market;

use App\Models\Items\Item;
use App\Models\Market\MarketOffer;
use App\Models\User;

class CalculateReservedCosmeticAmountAfterOfferCancellation
{
    public function handle(User $user, MarketOffer $offer): void
    {
        $user->items()
            ->whereIn('item_id', $offer->items->pluck('item_id'))
            ->each(function (Item $cosmetic) use ($offer) {
                $cosmetic->pivot->reserved_amount -= $offer->items->where('item_id', $cosmetic->getKey())->first()->amount;
                $cosmetic->pivot->save();
            });
    }
}
