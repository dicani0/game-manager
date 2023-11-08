<?php

namespace App\Processes\Guild;

use App\Processes\Process;
use App\Tasks\Guild\EditGuildTask;
use App\Tasks\Guild\TransferLeadershipTask;

class EditGuildProcess extends Process
{
    protected array $tasks = [
        EditGuildTask::class,
        TransferLeadershipTask::class,
    ];
}
