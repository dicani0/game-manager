<?php

namespace App\Tasks\Market\OfferRequests;

use App\Actions\Market\TradeOffers\UpdateOfferItemsAmountAfterAcceptedTrade;
use App\Models\Market\TradeOffer;

readonly class UpdateOfferItemsAmountAfterAcceptedTradeTask
{
    public function __construct(
        private UpdateOfferItemsAmountAfterAcceptedTrade $action
    ) {
    }

    public function handle(TradeOffer $request, \Closure $next): TradeOffer
    {
        $this->action->handle($request);

        return $next($request);
    }
}
