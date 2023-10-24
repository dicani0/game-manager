<?php

namespace App\Processes\Guild;

use App\Processes\Process;
use App\Tasks\Guild\CreateNewGuildTask;
use App\Tasks\Guild\SetGuildLeaderTask;

class CreateGuildProcess extends Process
{
    protected array $tasks = [
        CreateNewGuildTask::class,
        SetGuildLeaderTask::class,
    ];
}