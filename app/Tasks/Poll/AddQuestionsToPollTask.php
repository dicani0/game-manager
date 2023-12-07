<?php

namespace App\Tasks\Poll;

use App\Actions\Poll\AddQuestionsToPoll;
use App\Data\Poll\CreatePollDto;
use Closure;

class AddQuestionsToPollTask
{
    public function __construct(
        protected AddQuestionsToPoll $action
    ) {
    }

    public function handle(CreatePollDto $dto, Closure $next): CreatePollDto
    {
        $this->action->handle($dto->poll, $dto->questions);

        return $next($dto);
    }
}
