<?php

namespace App\Tasks\Poll;

use App\Actions\Poll\CreatePoll;
use App\Data\Poll\CreatePollDto;
use Closure;

class CreatePollTask
{
    public function __construct(
        protected CreatePoll $action
    )
    {
    }

    public function handle(CreatePollDto $dto, Closure $next): CreatePollDto
    {
        $dto->poll = $this->action->handle($dto);
        return $next($dto);
    }
}
