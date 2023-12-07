<?php

namespace App\Queries\Guild;

use App\Enums\GuildInvitationStatus;
use App\Models\Guild\GuildInvitation;
use App\Models\User;
use Spatie\QueryBuilder\QueryBuilder;

class GuildInvitationQuery
{
    public function handle(User $user, GuildInvitationStatus $status = GuildInvitationStatus::PENDING): QueryBuilder
    {
        return QueryBuilder::for(GuildInvitation::class)
            ->whereIn('character_id', $user->characters->pluck('id'))
            ->where('status', $status);
    }
}
