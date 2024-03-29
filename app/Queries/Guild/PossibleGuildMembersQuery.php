<?php

namespace App\Queries\Guild;

use App\Enums\GuildInvitationStatus;
use App\Models\Character\Character;
use App\Models\Guild\Guild;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\QueryBuilder;

class PossibleGuildMembersQuery
{
    public function handle(Guild $guild): QueryBuilder|Builder
    {
        return QueryBuilder::for(Character::class)
            ->whereDoesntHave('guildCharacter')
            ->whereDoesntHave(
                'guildInvitation',
                fn (Builder $query) => $query
                    ->where('guild_id', $guild->getKey())
                    ->where('status', GuildInvitationStatus::PENDING->value)
            );
    }
}
