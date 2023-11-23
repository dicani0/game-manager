<?php

namespace App\Processes\Guild;

use App\Processes\Process;
use App\Tasks\Guild\RejectGuildInviteTask;

class RejectGuildInviteProcess extends Process
{
    protected array $tasks = [
        RejectGuildInviteTask::class,
    ];
}
