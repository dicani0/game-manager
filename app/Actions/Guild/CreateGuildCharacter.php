<?php

namespace App\Actions\Guild;

use App\Enums\GuildRoleEnum;
use App\Events\Guild\NewGuildCharacter;
use App\Models\Guild\Guild;
use App\Models\Guild\GuildCharacter;

class CreateGuildCharacter
{
    public function handle(Guild $guild, int $characterId): void
    {
        $guildCharacter = GuildCharacter::create([
            'guild_id' => $guild->getKey(),
            'character_id' => $characterId,
            'role' => GuildRoleEnum::MEMBER,
        ]);

        event(new NewGuildCharacter($guildCharacter));
    }
}
