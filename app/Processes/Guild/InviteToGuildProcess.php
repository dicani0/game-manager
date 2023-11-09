<?php

namespace App\Processes\Guild;

use App\Processes\Process;
use App\Tasks\Guild\InviteToGuildTask;

class InviteToGuildProcess extends Process
{
    protected array $tasks = [
        InviteToGuildTask::class,
    ];
}
