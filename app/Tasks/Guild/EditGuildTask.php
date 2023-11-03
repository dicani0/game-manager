<?php

namespace App\Tasks\Guild;

use App\Actions\Guild\CreateNewGuild;
use App\Actions\Guild\EditGuild;
use App\Data\Guild\CreateGuildDto;
use App\Data\Guild\EditGuildDto;
use Closure;

readonly class EditGuildTask
{
    public function __construct(private EditGuild $action)
    {
    }

    public function handle(EditGuildDto $dto, Closure $next): EditGuildDto
    {
        $dto->guild = $this->action->handle($dto);

        return $next($dto);
    }
}