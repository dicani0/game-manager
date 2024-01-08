<?php

namespace App\Tasks\Poll;

use App\Actions\Poll\AssociatePollable;
use App\Data\Poll\CreatePollDto;
use Closure;

class AssociatePollableTask
{
    public function __construct(
        protected AssociatePollable $action
    ) {
    }

    public function handle(CreatePollDto $dto, Closure $next): CreatePollDto
    {
        $this->action->handle($dto);

        return $next($dto);
    }
}
