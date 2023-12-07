<?php

namespace App\Actions\Market\TradeOffers\Handlers;

use App\Actions\Market\Interfaces\OfferableHandler;
use App\Models\Items\Item;
use App\Models\Market\TradeOffer;
use App\Models\User;
use Illuminate\Support\Collection;

class UserHandler implements OfferableHandler
{
    public function handle(TradeOffer $tradeOffer, Collection $itemsInRequest): void
    {
        /** @var User $user */
        $user = $tradeOffer->offerable;
        $itemsInRequest->each(function (Item $item) use ($user) {
            if ($user->items->contains('id', $item->getKey())) {
                $user->items->where('pivot.item_id', $item->getKey())->first()->pivot->increment('amount', $item->pivot->amount);
            } else {
                $user->items()->attach($item->getKey(), ['amount' => $item->pivot->amount]);
            }
        });
    }
}
