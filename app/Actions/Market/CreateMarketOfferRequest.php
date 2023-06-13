<?php

namespace App\Actions\Market;

use App\Data\Market\CreateMarketOfferRequestDto;
use App\Enums\OfferTypeEnum;

class CreateMarketOfferRequest
{
    public function handle(CreateMarketOfferRequestDto $dto)
    {
        $dto->offer->offers()->create([
            'user_id' => $dto->creator->getKey(),
            'at_price' => $dto->at_price,
            'lat_price' => $dto->lat_price,
            'type' => OfferTypeEnum::BUY->value,
            'message' => $dto->message,
        ]);
    }
}
