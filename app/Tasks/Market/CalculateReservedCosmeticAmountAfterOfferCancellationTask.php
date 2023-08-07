<?php

namespace App\Tasks\Market;

use App\Actions\Market\CalculateReservedCosmeticAmountAfterOfferCancellation;
use App\Data\Market\CancelMarketOfferDto;

class CalculateReservedCosmeticAmountAfterOfferCancellationTask
{
    public function __construct(protected CalculateReservedCosmeticAmountAfterOfferCancellation $action)
    {
    }

    public function handle(CancelMarketOfferDto $dto, \Closure $next): CancelMarketOfferDto
    {
        $this->action->handle($dto->user, $dto->offer);
        return $next($dto);
    }
}
