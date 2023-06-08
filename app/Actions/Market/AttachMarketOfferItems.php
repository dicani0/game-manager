<?php

namespace App\Actions\Market;

use App\Data\Market\CreateMarketOfferDto;
use App\Models\Market\MarketOffer;

class AttachMarketOfferItems
{
    public function handle(CreateMarketOfferDto $dto): MarketOffer
    {
        $dto->offer->items()->createMany($dto->items->toArray());

        return $dto->offer;
    }
}
