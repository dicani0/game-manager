<?php

namespace App\Tasks\Guild;

use App\Actions\Guild\SetGuildInvitationStatus;
use App\Enums\GuildInvitationStatus;
use App\Models\Guild\GuildInvitation;
use Closure;

readonly class RejectGuildInviteTask
{
    public function __construct(private SetGuildInvitationStatus $action)
    {
    }

    public function handle(GuildInvitation $guildInvitation, Closure $next): GuildInvitation
    {
        $this->action->handle($guildInvitation, GuildInvitationStatus::REJECTED);

        return $next($guildInvitation);
    }
}