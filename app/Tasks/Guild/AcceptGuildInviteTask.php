<?php

namespace App\Tasks\Guild;

use App\Actions\Guild\InviteToGuild;
use App\Actions\Guild\SetGuildInvitationStatus;
use App\Data\Guild\InviteToGuildDto;
use App\Enums\GuildInvitationStatus;
use App\Models\Guild\GuildInvitation;
use Closure;

readonly class AcceptGuildInviteTask
{
    public function __construct(private SetGuildInvitationStatus $action)
    {
    }

    public function handle(GuildInvitation $guildInvitation, Closure $next): GuildInvitation
    {
        $this->action->handle($guildInvitation, GuildInvitationStatus::ACCEPTED);

        return $next($guildInvitation);
    }
}