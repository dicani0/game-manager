<?php

namespace App\Actions\Guild;

use App\Enums\GuildRoleEnum;
use App\Models\Guild\Guild;
use App\Models\Guild\GuildCharacter;

class TransferLeadership
{
    public function handle(Guild $guild, int $guildMemberId): void
    {
        if ($guild->leader->getKey() === $guildMemberId) {
            return;
        }

        $guild->leader->update([
            'role' => GuildRoleEnum::MEMBER,
        ]);

        GuildCharacter::query()
            ->where('guild_id', $guild->getKey())
            ->where('character_id', $guildMemberId)
            ->update([
                'role' => GuildRoleEnum::LEADER,
            ]);
    }
}