<?php

namespace App\Tasks\Guild;

use App\Actions\Guild\SetGuildLeader;
use App\Data\Guild\CreateGuildDto;
use Closure;

readonly class SetGuildLeaderTask
{
    public function __construct(private SetGuildLeader $action)
    {
    }

    public function handle(CreateGuildDto $dto, Closure $next): CreateGuildDto
    {
        $this->action->handle($dto->guild, $dto->leader_id);
        return $next($dto);
    }
}