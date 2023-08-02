<?php

namespace App\Tasks\Market\OfferRequests;

use App\Actions\Market\TradeOffers\CancelOffersWithUnavailableItems;
use App\Models\Market\TradeOffer;

readonly class CancelOffersWithUnavailableItemsTask
{
    public function __construct(
        private CancelOffersWithUnavailableItems $action
    ) {
    }

    public function handle(TradeOffer $request, \Closure $next): TradeOffer
    {
        $this->action->handle($request);

        return $next($request);
    }
}
