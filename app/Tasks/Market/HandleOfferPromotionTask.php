<?php

namespace App\Tasks\Market;

use App\Actions\Market\HandleOfferPromotion;
use App\Data\Market\CreateMarketOfferDto;

class HandleOfferPromotionTask
{
    public function __construct(
        protected HandleOfferPromotion $action
    ) {
    }

    public function handle(CreateMarketOfferDto $dto, \Closure $next): CreateMarketOfferDto
    {
        $this->action->handle($dto);

        return $next($dto);
    }
}
