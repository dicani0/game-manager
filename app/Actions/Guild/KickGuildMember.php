<?php

namespace App\Actions\Guild;

use App\Models\Guild\GuildCharacter;

class KickGuildMember
{
    public function handle(GuildCharacter $guildCharacter): void
    {
        $guildCharacter->delete();
    }
}