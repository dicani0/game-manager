<?php

namespace App\Processes\Poll;

use App\Processes\Process;
use App\Tasks\Poll\SyncQuestionsInPollTask;
use App\Tasks\Poll\UpdateAnswersInQuestionTask;
use App\Tasks\Poll\UpdatePollTask;

class UpdatePollProcess extends Process
{
    protected array $tasks = [
        UpdatePollTask::class,
        SyncQuestionsInPollTask::class,
        UpdateAnswersInQuestionTask::class,
    ];
}
