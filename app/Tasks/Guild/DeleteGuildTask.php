<?php

namespace App\Tasks\Guild;

use App\Actions\Guild\DeleteGuild;
use App\Models\Guild\Guild;
use Closure;

readonly class DeleteGuildTask
{
    public function __construct(private DeleteGuild $action)
    {
    }

    public function handle(Guild $guild, Closure $next): Guild
    {
        $this->action->handle($guild);

        return $next($guild);
    }
}
