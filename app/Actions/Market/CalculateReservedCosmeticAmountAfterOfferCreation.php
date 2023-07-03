<?php

namespace App\Actions\Market;

use App\Data\Market\CreateMarketOfferDto;
use App\Models\Items\Item;

class CalculateReservedCosmeticAmountAfterOfferCreation
{
    public function handle(CreateMarketOfferDto $dto): void
    {
        $dto->user->items()
            ->whereIn('item_id', $dto->items->toCollection()->pluck('item_id'))
            ->each(function (Item $item) use ($dto) {
                $item->pivot->reserved_amount += $dto->items->toCollection()->where('item_id', $item->getKey())->first()->amount;
                $item->pivot->save();
            });
    }
}
