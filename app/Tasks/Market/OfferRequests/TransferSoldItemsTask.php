<?php

namespace App\Tasks\Market\OfferRequests;

use App\Actions\Market\OfferRequests\TransferSoldItems;
use App\Models\Market\OfferRequest;

readonly class TransferSoldItemsTask
{
    public function __construct(
        private TransferSoldItems $action
    ) {
    }

    public function handle(OfferRequest $request, \Closure $next): OfferRequest
    {
        $this->action->handle($request);

        return $next($request);
    }
}
