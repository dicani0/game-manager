<?php

namespace App\Tasks\Market\OfferRequests;

use App\Actions\Market\OfferRequests\UpdateOfferItemsAmountAfterAcceptedTrade;
use App\Models\Market\OfferRequest;

readonly class UpdateOfferItemsAmountAfterAcceptedTradeTask
{
    public function __construct(
        private UpdateOfferItemsAmountAfterAcceptedTrade $action
    ) {
    }

    public function handle(OfferRequest $request, \Closure $next): OfferRequest
    {
        $this->action->handle($request);

        return $next($request);
    }
}
