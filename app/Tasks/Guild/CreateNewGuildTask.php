<?php

namespace App\Tasks\Guild;

use App\Actions\Guild\CreateNewGuild;
use App\Data\Guild\CreateGuildDto;
use Closure;

readonly class CreateNewGuildTask
{
    public function __construct(private CreateNewGuild $action)
    {
    }

    public function handle(CreateGuildDto $dto, Closure $next): CreateGuildDto
    {
        $dto->guild = $this->action->handle($dto);

        return $next($dto);
    }
}
