<?php

namespace App\Actions\Market\TradeOffers;

use App\Enums\MarketOfferRequestStatusEnum;
use App\Models\Market\TradeOffer;

class AcceptTradeOffer
{
    public function handle(TradeOffer $tradeOffer): void
    {
        $tradeOffer->update([
            'status' => MarketOfferRequestStatusEnum::ACCEPTED->value,
        ]);
    }
}
