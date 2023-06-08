<?php

namespace App\Processes\Market;

use App\Processes\Process;
use App\Tasks\Market\AttachMarketOfferItemsTask;
use App\Tasks\Market\CalculateReservedCosmeticAmountAfterOfferCreationTask;
use App\Tasks\Market\CreateMarketOfferTask;
use App\Tasks\Market\HandleOfferPromotionTask;

class CreateMarketOfferProcess extends Process
{
    protected array $tasks = [
        HandleOfferPromotionTask::class,
        CreateMarketOfferTask::class,
        AttachMarketOfferItemsTask::class,
        CalculateReservedCosmeticAmountAfterOfferCreationTask::class,
    ];
}
