<?php

namespace App\Tasks\Guild;

use App\Actions\Guild\CreateGuildCharacter;
use App\Models\Guild\GuildInvitation;
use Closure;

readonly class CreateGuildCharacterTask
{
    public function __construct(private CreateGuildCharacter $action)
    {
    }

    public function handle(GuildInvitation $guildInvitation, Closure $next): GuildInvitation
    {
        $this->action->handle($guildInvitation->guild, $guildInvitation->character_id);

        return $next($guildInvitation);
    }
}
