<?php

namespace App\Actions\Market;

use App\Data\Market\CancelMarketOfferDto;
use App\Enums\MarketOfferStatusEnum;
use App\Models\Market\MarketOffer;

class CancelMarketOffer
{
    public function handle(CancelMarketOfferDto $dto): MarketOffer
    {
        $dto->offer->update([
            'status' => MarketOfferStatusEnum::CANCELED->value,
        ]);

        return $dto->offer;
    }
}
