<?php

namespace App\Actions\Market\TradeOffers;

use App\Actions\Market\Interfaces\OfferableHandler;
use App\Actions\Market\TradeOffers\Handlers\MarketOfferHandler;
use App\Actions\Market\TradeOffers\Handlers\UserHandler;
use App\Models\Interfaces\Offerable;
use App\Models\Market\MarketOffer;
use App\Models\Market\TradeOffer;
use App\Models\User;
use Exception;

class UpdateOfferItemsAmountAfterAcceptedTrade
{
    public function handle(TradeOffer $tradeOffer): void
    {
        $itemsInRequest = $tradeOffer->items->keyBy('id');

        assert($tradeOffer->offerable instanceof Offerable);

        $handler = $this->getOfferableHandler($tradeOffer->offerable);
        $handler->handle($tradeOffer, $itemsInRequest);
    }

    private function getOfferableHandler(Offerable $offerable): OfferableHandler
    {
        return match (true) {
            $offerable instanceof MarketOffer => new MarketOfferHandler(),
            $offerable instanceof User => new UserHandler(),
            default => throw new Exception('Unsupported offerable type'),
        };
    }
}
