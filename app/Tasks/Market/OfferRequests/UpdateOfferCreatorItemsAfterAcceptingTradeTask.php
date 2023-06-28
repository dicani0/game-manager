<?php

namespace App\Tasks\Market\OfferRequests;

use App\Actions\Market\TradeOffers\UpdateOfferCreatorItemsAfterAcceptingTrade;
use App\Models\Market\TradeOffer;

readonly class UpdateOfferCreatorItemsAfterAcceptingTradeTask
{
    public function __construct(
        private UpdateOfferCreatorItemsAfterAcceptingTrade $action
    ) {
    }

    public function handle(TradeOffer $request, \Closure $next): TradeOffer
    {
        $this->action->handle($request);

        return $next($request);
    }
}
