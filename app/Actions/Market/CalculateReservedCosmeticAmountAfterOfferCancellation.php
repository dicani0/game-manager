<?php

namespace App\Actions\Market;

use App\Data\Market\CancelMarketOfferDto;

class CalculateReservedCosmeticAmountAfterOfferCancellation
{
    public function handle(CancelMarketOfferDto $dto): void
    {
        $dto->user->cosmetics()
            ->whereIn('cosmetic_id', $dto->offer->items->pluck('cosmetic_id'))
            ->each(function ($cosmetic) use ($dto) {
                $cosmetic->pivot->reserved_amount -= $dto->offer->items->where('cosmetic_id', $cosmetic->getKey())->first()->amount;
                $cosmetic->pivot->save();
            });
    }
}
