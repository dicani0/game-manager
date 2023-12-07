<?php

namespace App\Tasks\Market;

use App\Actions\Market\CalculateReservedCosmeticAmountAfterOfferCreation;
use App\Data\Market\CreateMarketOfferDto;

class CalculateReservedCosmeticAmountAfterOfferCreationTask
{
    public function __construct(protected CalculateReservedCosmeticAmountAfterOfferCreation $action)
    {
    }

    public function handle(CreateMarketOfferDto $dto, \Closure $next): CreateMarketOfferDto
    {
        $this->action->handle($dto);

        return $next($dto);
    }
}
