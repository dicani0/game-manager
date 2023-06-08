<?php

namespace App\Actions\Market;

use App\Data\Market\CreateMarketOfferDto;

class CalculateReservedCosmeticAmountAfterOfferCreation
{
    public function handle(CreateMarketOfferDto $dto): void
    {
        $dto->user->cosmetics()
            ->whereIn('cosmetic_id', $dto->items->toCollection()->pluck('cosmetic_id'))
            ->each(function ($cosmetic) use ($dto) {
                $cosmetic->pivot->reserved_amount += $dto->items->toCollection()->where('cosmetic_id', $cosmetic->getKey())->first()->amount;
                $cosmetic->pivot->save();
            });
    }
}
