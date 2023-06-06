<?php

namespace App\Actions\Market;

use App\Data\Market\CreateMarketOfferDto;
use App\Enums\OfferTypeEnum;
use App\Models\Market\MarketOffer;

class CreateMarketOffer
{
    public function handle(CreateMarketOfferDto $dto): MarketOffer
    {
        return MarketOffer::create([
            'user_id' => $dto->user->getKey(),
            'promoted' => $dto->promoted,
            'type' => OfferTypeEnum::SELL->value,
            'expires_at' => now()->addDays(14)->startOfDay(),
        ]);
    }
}
