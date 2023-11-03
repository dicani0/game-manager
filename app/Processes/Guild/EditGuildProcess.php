<?php

namespace App\Processes\Guild;

use App\Processes\Process;
use App\Tasks\Guild\EditGuildTask;

class EditGuildProcess extends Process
{
    protected array $tasks = [
        EditGuildTask::class,
    ];
}
