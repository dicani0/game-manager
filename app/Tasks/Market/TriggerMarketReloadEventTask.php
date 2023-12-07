<?php

namespace App\Tasks\Market;

use App\Actions\Market\TriggerMarketReloadEvent;
use App\Data\Market\CreateMarketOfferDto;
use Closure;

class TriggerMarketReloadEventTask
{
    public function __construct(
        protected TriggerMarketReloadEvent $action
    ) {
    }

    public function handle(CreateMarketOfferDto $dto, Closure $next): CreateMarketOfferDto
    {
        $this->action->handle();

        return $next($dto);
    }
}
