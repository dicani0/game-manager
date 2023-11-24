<?php

namespace App\Processes\Guild;

use App\Processes\Process;
use App\Tasks\Guild\KickFromGuildTask;

class KickFromGuildProcess extends Process
{
    protected array $tasks = [
        KickFromGuildTask::class,
    ];
}
