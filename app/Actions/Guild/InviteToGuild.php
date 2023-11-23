<?php

namespace App\Actions\Guild;

use App\Data\Guild\InviteToGuildDto;
use App\Enums\GuildRoleEnum;
use App\Events\Guild\InvitedToGuild;
use App\Models\Guild\GuildInvitation;

class InviteToGuild
{
    public function handle(InviteToGuildDto $dto): void
    {
        GuildInvitation::create([
            'guild_id' => $dto->guild->id,
            'character_id' => $dto->character->getKey(),
            'role' => GuildRoleEnum::MEMBER,
        ]);

        event(new InvitedToGuild($dto->character->user));
    }
}