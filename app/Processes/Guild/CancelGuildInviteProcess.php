<?php

namespace App\Processes\Guild;

use App\Processes\Process;
use App\Tasks\Guild\CancelGuildInviteTask;

class CancelGuildInviteProcess extends Process
{
    protected array $tasks = [
        CancelGuildInviteTask::class,
    ];
}
