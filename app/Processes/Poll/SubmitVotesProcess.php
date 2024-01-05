<?php

namespace App\Processes\Poll;

use App\Processes\Process;
use App\Tasks\Poll\CreateVotesTask;

class SubmitVotesProcess extends Process
{
    protected array $tasks = [
        CreateVotesTask::class,
    ];
}
