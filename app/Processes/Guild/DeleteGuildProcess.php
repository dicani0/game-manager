<?php

namespace App\Processes\Guild;

use App\Processes\Process;
use App\Tasks\Guild\DeleteGuildTask;

class DeleteGuildProcess extends Process
{
    protected array $tasks = [
        DeleteGuildTask::class,
    ];
}
