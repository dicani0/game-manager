<?php

namespace App\Tasks\Guild;

use App\Actions\Guild\InviteToGuild;
use App\Data\Guild\InviteToGuildDto;
use Closure;

readonly class InviteToGuildTask
{
    public function __construct(private InviteToGuild $action)
    {
    }

    public function handle(InviteToGuildDto $dto, Closure $next): InviteToGuildDto
    {
        $this->action->handle($dto);
        return $next($dto);
    }
}