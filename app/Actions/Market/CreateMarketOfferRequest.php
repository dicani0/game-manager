<?php

namespace App\Actions\Market;

use App\Data\Market\CreateMarketOfferRequestDto;
use App\Enums\OfferTypeEnum;

class CreateMarketOfferRequest
{
    /**
     * @throws \Exception
     */
    public function handle(CreateMarketOfferRequestDto $dto)
    {
        if (
            config('market.max_offers_enabled')
            && $dto->offer->offers()->where('user_id', $dto->creator->getKey())->count() >= config('market.max_offers_per_user', 5)
        ) {
            throw new \Exception('You can only have 3 offers per market offer!');
        }

        $dto->offerRequest = $dto->offer->offers()->create([
            'user_id' => $dto->creator->getKey(),
            'at_price' => $dto->at_price,
            'lat_price' => $dto->lat_price,
            'type' => OfferTypeEnum::BUY->value,
            'message' => $dto->message,
        ]);
    }
}
