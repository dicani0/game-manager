<?php

namespace App\Actions\Market\OfferRequests;

use App\Enums\MarketOfferStatusEnum;
use App\Models\Market\MarketOffer;
use App\Models\Market\OfferRequest;

class CancelOffersWithSoldItems
{
    public function handle(OfferRequest $request): void
    {
        if ($request->offerable instanceof MarketOffer) {
            $request->offerable->offers
                ->whereNot('id', $request->getKey())
                ->whereNotIn('status', [
                    MarketOfferStatusEnum::CANCELED,
                    MarketOfferStatusEnum::FINISHED,
                ])
                ->update([
                    'status' => MarketOfferStatusEnum::CANCELED,
                ]);
        }
    }
}
