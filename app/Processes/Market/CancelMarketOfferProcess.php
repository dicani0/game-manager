<?php

namespace App\Processes\Market;

use App\Processes\Process;
use App\Tasks\Market\CalculateReservedCosmeticAmountAfterOfferCancellationTask;
use App\Tasks\Market\CancelMarketOfferTask;

class CancelMarketOfferProcess extends Process
{
    protected array $tasks = [
        CancelMarketOfferTask::class,
        CalculateReservedCosmeticAmountAfterOfferCancellationTask::class
    ];
}
