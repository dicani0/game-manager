<?php

namespace App\Processes\Market;

use App\Processes\Process;
use App\Tasks\Market\AttachMarketOfferItemsTask;
use App\Tasks\Market\CalculateReservedCosmeticAmountAfterOfferCreationTask;
use App\Tasks\Market\CreateMarketOfferRequestTask;
use App\Tasks\Market\CreateMarketOfferTask;
use App\Tasks\Market\HandleOfferPromotionTask;
use App\Tasks\Market\NotifyUserAboutOfferRequestTask;

class CreateBuyOfferRequestProcess extends Process
{
    protected array $tasks = [
        CreateMarketOfferRequestTask::class,
        NotifyUserAboutOfferRequestTask::class
    ];
}
