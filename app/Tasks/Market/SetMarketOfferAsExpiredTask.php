<?php

namespace App\Tasks\Market;

use App\Actions\Market\SetMarketOfferAsExpired;
use App\Data\Market\CreateMarketOfferDto;
use Closure;

class SetMarketOfferAsExpiredTask
{
    public function __construct(
        protected SetMarketOfferAsExpired $action
    ) {
    }

    public function handle(CreateMarketOfferDto $dto, Closure $next): CreateMarketOfferDto
    {
        $this->action->handle($dto->offer);

        return $next($dto);
    }
}
