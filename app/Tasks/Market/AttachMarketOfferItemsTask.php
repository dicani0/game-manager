<?php

namespace App\Tasks\Market;

use App\Actions\Market\AttachMarketOfferItems;
use App\Data\Market\CreateMarketOfferDto;

class AttachMarketOfferItemsTask
{
    public function __construct(protected AttachMarketOfferItems $action)
    {
    }

    public function handle(CreateMarketOfferDto $dto, \Closure $next): CreateMarketOfferDto
    {
        $this->action->handle($dto);
        return $next($dto);
    }
}
