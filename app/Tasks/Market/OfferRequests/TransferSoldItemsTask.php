<?php

namespace App\Tasks\Market\OfferRequests;

use App\Actions\Market\TradeOffers\TransferSoldItems;
use App\Models\Market\TradeOffer;

readonly class TransferSoldItemsTask
{
    public function __construct(
        private TransferSoldItems $action
    ) {
    }

    public function handle(TradeOffer $request, \Closure $next): TradeOffer
    {
        $this->action->handle($request);

        return $next($request);
    }
}
