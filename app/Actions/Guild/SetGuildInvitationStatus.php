<?php

namespace App\Actions\Guild;

use App\Enums\GuildInvitationStatus;
use App\Models\Guild\GuildInvitation;

class SetGuildInvitationStatus
{
    public function handle(GuildInvitation $guildInvitation, GuildInvitationStatus $status): void
    {
        $guildInvitation->update(['status' => $status]);
    }
}