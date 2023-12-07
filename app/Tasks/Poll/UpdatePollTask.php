<?php

namespace App\Tasks\Poll;

use App\Actions\Poll\UpdatePoll;
use App\Data\Poll\UpdatePollDto;
use Closure;

class UpdatePollTask
{
    public function __construct(
        protected UpdatePoll $action
    )
    {
    }

    public function handle(UpdatePollDto $dto, Closure $next): UpdatePollDto
    {
        $this->action->handle($dto);
        return $next($dto);
    }
}
