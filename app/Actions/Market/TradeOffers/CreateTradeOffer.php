<?php

namespace App\Actions\Market\TradeOffers;

use App\Data\Market\CreateTradeOfferDto;
use App\Enums\OfferTypeEnum;
use App\Events\Market\TradeOfferCreated;
use Illuminate\Support\Facades\Log;

class CreateTradeOffer
{
    /**
     * @throws \Exception
     */
    public function handle(CreateTradeOfferDto $dto)
    {
        if (
            config('market.max_offers_enabled')
            && $dto->offer->offers()->where('user_id', $dto->creator->getKey())->count() >= config('market.max_offers_per_user', 5)
        ) {
            throw new \Exception('You can only have ' . config('max_offers_per_user') . ' offers per market offer!');
        }

        $dto->tradeOffer = $dto->offer->offers()->create([
            'user_id' => $dto->creator->getKey(),
            'at_price' => $dto->at_price,
            'lat_price' => $dto->lat_price,
            'type' => OfferTypeEnum::BUY->value,
            'message' => $dto->message,
        ]);

        event(new TradeOfferCreated($dto->tradeOffer));
    }
}
