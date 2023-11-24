<?php

namespace App\Processes\Guild;

use App\Processes\Process;
use App\Tasks\Guild\AcceptGuildInviteTask;
use App\Tasks\Guild\CreateGuildCharacterTask;
use App\Tasks\Guild\RejectOtherInvitationsAfterJoiningGuildTask;

class AcceptGuildInviteProcess extends Process
{
    protected array $tasks = [
        AcceptGuildInviteTask::class,
        RejectOtherInvitationsAfterJoiningGuildTask::class,
        CreateGuildCharacterTask::class,
    ];
}
