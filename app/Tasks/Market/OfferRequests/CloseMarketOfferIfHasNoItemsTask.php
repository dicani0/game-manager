<?php

namespace App\Tasks\Market\OfferRequests;

use App\Actions\Market\OfferRequests\CloseMarketOfferIfHasNoItems;
use App\Models\Market\OfferRequest;

readonly class CloseMarketOfferIfHasNoItemsTask
{
    public function __construct(
        private CloseMarketOfferIfHasNoItems $action,
    ) {
    }
    public function handle(OfferRequest $request, \Closure $next): OfferRequest
    {
        $this->action->handle($request->offerable);

        return $next($request);
    }
}
