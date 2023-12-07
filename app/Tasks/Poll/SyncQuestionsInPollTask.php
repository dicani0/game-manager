<?php

namespace App\Tasks\Poll;

use App\Actions\Poll\SyncQuestionsInPoll;
use App\Data\Poll\UpdatePollDto;
use Closure;

class SyncQuestionsInPollTask
{
    public function __construct(
        protected SyncQuestionsInPoll $action
    )
    {

    }

    public function handle(UpdatePollDto $dto, Closure $next): UpdatePollDto
    {
        $this->action->handle($dto->poll, $dto->questions);
        return $next($dto);
    }
}
