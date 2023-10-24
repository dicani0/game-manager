<?php

namespace App\Actions\Market\TradeOffers;

use App\Data\Market\CreateTradeOfferDto;

class AttachItemsToTradeOffer
{
    public function handle(CreateTradeOfferDto $dto): void
    {
        $items = $dto->items->toCollection()->mapWithKeys(function ($item) {
            return [$item->id => ['amount' => $item->amount]];
        });

        $dto->tradeOffer->items()->sync($items->toArray());
    }
}
