<?php

namespace App\Tasks\Market\OfferRequests;

use App\Actions\Market\TradeOffers\CloseMarketOfferIfHasNoItems;
use App\Models\Market\TradeOffer;

readonly class CloseMarketOfferIfHasNoItemsTask
{
    public function __construct(
        private CloseMarketOfferIfHasNoItems $action,
    ) {
    }
    public function handle(TradeOffer $request, \Closure $next): TradeOffer
    {
        $this->action->handle($request->offerable);

        return $next($request);
    }
}
