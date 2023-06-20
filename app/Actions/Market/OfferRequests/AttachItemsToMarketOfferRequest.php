<?php

namespace App\Actions\Market\OfferRequests;

use App\Data\Market\CreateMarketOfferRequestDto;

class AttachItemsToMarketOfferRequest
{
    public function handle(CreateMarketOfferRequestDto $dto)
    {
        $items = $dto->items->toCollection()->map(function ($item) {
            return [
                'cosmetic_id' => $item->id,
                'amount' => $item->amount,
            ];
        });
        $dto->offerRequest->cosmetics()->attach($items);
    }
}
