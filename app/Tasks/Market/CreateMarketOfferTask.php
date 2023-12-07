<?php

namespace App\Tasks\Market;

use App\Actions\Market\CreateMarketOffer;
use App\Data\Market\CreateMarketOfferDto;

class CreateMarketOfferTask
{
    public function __construct(
        protected CreateMarketOffer $action
    ) {
    }

    public function handle(CreateMarketOfferDto $dto, \Closure $next): CreateMarketOfferDto
    {
        $dto->offer = $this->action->handle($dto);

        return $next($dto);
    }
}
