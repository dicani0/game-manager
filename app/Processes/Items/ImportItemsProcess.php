<?php

namespace App\Processes\Items;

use App\Processes\Process;
use App\Tasks\Items\ParseItemsTask;
use App\Tasks\Items\SyncUserItemsTask;

class ImportItemsProcess extends Process
{
    protected array $tasks = [
        ParseItemsTask::class,
        SyncUserItemsTask::class
    ];
}
