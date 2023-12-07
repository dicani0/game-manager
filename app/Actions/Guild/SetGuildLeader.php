<?php

namespace App\Actions\Guild;

use App\Enums\GuildRoleEnum;
use App\Models\Guild\Guild;
use App\Models\Guild\GuildCharacter;

class SetGuildLeader
{
    public function handle(Guild $guild, int $characterId): void
    {
        GuildCharacter::create([
            'guild_id' => $guild->getKey(),
            'character_id' => $characterId,
            'role' => GuildRoleEnum::LEADER,
        ]);
    }
}
