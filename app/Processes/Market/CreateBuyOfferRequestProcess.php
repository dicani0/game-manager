<?php

namespace App\Processes\Market;

use App\Processes\Process;
use App\Tasks\Market\AttachItemsToMarketOfferRequestTask;
use App\Tasks\Market\CreateMarketOfferRequestTask;
use App\Tasks\Market\NotifyUserAboutOfferRequestTask;

class CreateBuyOfferRequestProcess extends Process
{
    protected array $tasks = [
        CreateMarketOfferRequestTask::class,
        AttachItemsToMarketOfferRequestTask::class,
        NotifyUserAboutOfferRequestTask::class
    ];
}
