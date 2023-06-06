<?php

namespace App\Processes\Market;

use App\Processes\Process;
use App\Tasks\Market\AttachMarketOfferItemsTask;
use App\Tasks\Market\CalculateReservedCosmeticAmountAfterOfferCreationTask;
use App\Tasks\Market\CreateMarketOfferTask;

class CreateMarketOfferProcess extends Process
{
    protected array $tasks = [
        CreateMarketOfferTask::class,
        AttachMarketOfferItemsTask::class,
        CalculateReservedCosmeticAmountAfterOfferCreationTask::class,
    ];
}
