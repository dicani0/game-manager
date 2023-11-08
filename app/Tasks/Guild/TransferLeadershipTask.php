<?php

namespace App\Tasks\Guild;

use App\Actions\Guild\TransferLeadership;
use App\Data\Guild\EditGuildDto;
use Closure;

readonly class TransferLeadershipTask
{
    public function __construct(private TransferLeadership $action)
    {
    }

    public function handle(EditGuildDto $dto, Closure $next): EditGuildDto
    {
        $this->action->handle($dto->guild, $dto->leader_id);
        return $next($dto);
    }
}