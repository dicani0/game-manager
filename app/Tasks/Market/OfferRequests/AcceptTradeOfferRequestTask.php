<?php

namespace App\Tasks\Market\OfferRequests;

use App\Actions\Market\TradeOffers\AcceptTradeOffer;
use App\Models\Market\TradeOffer;

readonly class AcceptTradeOfferRequestTask
{
    public function __construct(
        private AcceptTradeOffer $action,
    ) {
    }

    public function handle(TradeOffer $request, \Closure $next): TradeOffer
    {
        $this->action->handle($request);

        return $next($request);
    }
}
