<?php

namespace App\Processes\Market;

use App\Processes\Process;
use App\Tasks\Market\OfferRequests\AcceptTradeOfferRequestTask;
use App\Tasks\Market\OfferRequests\UpdateOfferCreatorItemsAfterAcceptingTradeTask;
use App\Tasks\Market\OfferRequests\UpdateOfferItemsAmountAfterAcceptedTradeTask;

class AcceptTradeRequestProcess extends Process
{
    protected array $tasks = [
        AcceptTradeOfferRequestTask::class,
        UpdateOfferItemsAmountAfterAcceptedTradeTask::class,
        UpdateOfferCreatorItemsAfterAcceptingTradeTask::class,
//        CancelOffersWithSoldItemsTask::class,
    ];
}
