<?php

namespace App\Actions\Guild;

use App\Enums\GuildInvitationStatus;
use App\Models\Character\Character;

class RejectOtherInvitationsAfterJoiningGuild
{
    public function handle(Character $character): void
    {
        $character->guildInvitation()
            ->where('status', GuildInvitationStatus::PENDING->value)
            ->update(['status' => GuildInvitationStatus::REJECTED->value]);
    }
}