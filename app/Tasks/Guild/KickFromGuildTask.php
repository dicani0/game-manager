<?php

namespace App\Tasks\Guild;

use App\Actions\Guild\KickGuildMember;
use App\Models\Guild\GuildCharacter;
use Closure;

readonly class KickFromGuildTask
{
    public function __construct(private KickGuildMember $action)
    {
    }

    public function handle(GuildCharacter $member, Closure $next): GuildCharacter
    {
        $this->action->handle($member);

        return $next($member);
    }
}
