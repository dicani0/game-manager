<?php

namespace App\Tasks\Guild;

use App\Actions\Guild\RejectOtherInvitationsAfterJoiningGuild;
use App\Models\Guild\GuildInvitation;
use Closure;

readonly class RejectOtherInvitationsAfterJoiningGuildTask
{
    public function __construct(private RejectOtherInvitationsAfterJoiningGuild $action)
    {
    }

    public function handle(GuildInvitation $guildInvitation, Closure $next): GuildInvitation
    {
        $this->action->handle($guildInvitation->character);

        return $next($guildInvitation);
    }
}
