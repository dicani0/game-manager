<?php

namespace App\Actions\Market\TradeOffers;

use App\Enums\MarketOfferStatusEnum;
use App\Models\Interfaces\Offerable;
use App\Models\Market\MarketOffer;

class CloseMarketOfferIfHasNoItems
{
    public function handle(Offerable $marketOffer): void
    {
        if (! $marketOffer instanceof MarketOffer) {
            return;
        }

        if ($marketOffer->items()->count() === 0) {
            $marketOffer->update([
                'status' => MarketOfferStatusEnum::FINISHED->value,
            ]);
        }
    }
}
