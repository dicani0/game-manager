<?php

namespace App\Tasks\Market\OfferRequests;

use App\Actions\Market\OfferRequests\AcceptTradeOfferRequest;
use App\Models\Market\OfferRequest;

readonly class AcceptTradeOfferRequestTask
{
    public function __construct(
        private AcceptTradeOfferRequest $action,
    ) {
    }
    public function handle(OfferRequest $request, \Closure $next): OfferRequest
    {
        $this->action->handle($request);

        return $next($request);
    }
}
