<?php

namespace App\Tasks\Market\OfferRequests;

use App\Actions\Market\OfferRequests\CancelOffersWithSoldItems;
use App\Models\Market\OfferRequest;

readonly class CancelOffersWithSoldItemsTask
{
    public function __construct(
        private CancelOffersWithSoldItems $action
    ) {
    }

    public function handle(OfferRequest $request, \Closure $next): OfferRequest
    {
        $this->action->handle($request);

        return $next($request);
    }
}
