<?php

namespace App\Processes\Poll;

use App\Processes\Process;
use App\Tasks\Poll\AddAnswersToQuestionTask;
use App\Tasks\Poll\AddQuestionsToPollTask;
use App\Tasks\Poll\CreatePollTask;

class CreatePollProcess extends Process
{
    protected array $tasks = [
        CreatePollTask::class,
        AddQuestionsToPollTask::class,
        AddAnswersToQuestionTask::class,
    ];
}
