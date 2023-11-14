<?php

namespace App\Processes\Guild;

use App\Processes\Process;
use App\Tasks\Guild\CancelGuildInviteTask;
use App\Tasks\Guild\CreateGuildCharacterTask;

class CancelGuildInviteProcess extends Process
{
    protected array $tasks = [
        CancelGuildInviteTask::class,
        CreateGuildCharacterTask::class,
    ];
}
