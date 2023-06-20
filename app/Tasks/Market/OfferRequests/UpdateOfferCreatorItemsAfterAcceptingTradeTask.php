<?php

namespace App\Tasks\Market\OfferRequests;

use App\Actions\Market\OfferRequests\UpdateOfferCreatorItemsAfterAcceptingTrade;
use App\Models\Market\OfferRequest;

readonly class UpdateOfferCreatorItemsAfterAcceptingTradeTask
{
    public function __construct(
        private UpdateOfferCreatorItemsAfterAcceptingTrade $action
    ) {
    }

    public function handle(OfferRequest $request, \Closure $next): OfferRequest
    {
        $this->action->handle($request);

        return $next($request);
    }
}
