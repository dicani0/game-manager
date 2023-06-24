<?php

namespace App\Tasks\Market\OfferRequests;

use App\Actions\Market\OfferRequests\CancelOffersWithUnavailableItems;
use App\Models\Market\OfferRequest;

readonly class CancelOffersWithUnavailableItemsTask
{
    public function __construct(
        private CancelOffersWithUnavailableItems $action
    ) {
    }

    public function handle(OfferRequest $request, \Closure $next): OfferRequest
    {
        $this->action->handle($request);

        return $next($request);
    }
}
