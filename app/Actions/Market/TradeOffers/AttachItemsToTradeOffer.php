<?php

namespace App\Actions\Market\TradeOffers;

use App\Data\Market\CreateTradeOfferDto;

class AttachItemsToTradeOffer
{
    public function handle(CreateTradeOfferDto $dto)
    {
        $items = $dto->items->toCollection()->map(function ($item) {
            return [
                'item_id' => $item->id,
                'amount' => $item->amount,
            ];
        });
        
        $dto->tradeOffer->items()->attach($items);
    }
}
