<?php

namespace App\Actions\Market\TradeOffers;

use App\Enums\MarketOfferStatusEnum;
use App\Models\Market\MarketOffer;

class CloseMarketOfferIfHasNoItems
{
    public function handle(MarketOffer $marketOffer): void
    {
        if ($marketOffer->items()->count() === 0) {
            $marketOffer->update([
                'status' => MarketOfferStatusEnum::FINISHED->value,
            ]);
        }
    }
}
