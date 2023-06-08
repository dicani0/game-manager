<?php

namespace App\Tasks\Market;

use App\Actions\Market\CancelMarketOffer;
use App\Data\Market\CancelMarketOfferDto;

class CancelMarketOfferTask
{
    public function __construct(
        protected CancelMarketOffer $action
    )
    {
    }

    public function handle(CancelMarketOfferDto $dto, \Closure $next): CancelMarketOfferDto
    {
        $this->action->handle($dto);
        return $next($dto);
    }
}
