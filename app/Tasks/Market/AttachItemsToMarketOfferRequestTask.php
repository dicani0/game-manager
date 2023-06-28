<?php

namespace App\Tasks\Market;

use App\Actions\Market\OfferRequests\AttachItemsToMarketOfferRequest;
use App\Data\Market\CreateMarketOfferRequestDto;

class AttachItemsToMarketOfferRequestTask
{
    public function __construct(
        protected AttachItemsToMarketOfferRequest $action
    )
    {
    }

    public function handle(CreateMarketOfferRequestDto $dto, \Closure $next): CreateMarketOfferRequestDto
    {
        $this->action->handle($dto);
        return $next($dto);
    }
}
