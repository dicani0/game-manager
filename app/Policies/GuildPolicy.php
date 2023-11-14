<?php

namespace App\Policies;

use App\Enums\GuildRoleEnum;
use App\Models\Guild\Guild;
use App\Models\Guild\GuildCharacter;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Config;

class GuildPolicy
{
    public function create(User $user): bool
    {
        if (!Config::get('guilds.amount_limitation.enabled')) {
            return true;
        }

        return Guild::query()->whereHas(
                'characters',
                fn(Builder $query) => $query->whereIn('character_id', $user->characters->pluck('id')->toArray())
            )->count() < Config::get('guilds.amount_limitation.max_guilds_per_user');
    }

    public function store(User $user): bool
    {
        return $this->create($user);
    }

    public function update(User $user, Guild $guild): bool
    {
        return $guild->isLeader($user);
    }

    public function delete(User $user, Guild $guild): bool
    {
        return $guild->isLeader($user);
    }

    public function kick(User $user, Guild $guild, GuildCharacter $character): bool
    {
        if ($character->guild_id !== $guild->getKey()) {
            return false;
        }

        if ($guild->isLeader($user) && $character->role !== GuildRoleEnum::LEADER) {
            return true;
        }

        if ($guild->isViceLeader($user) && $character->role !== GuildRoleEnum::LEADER
            && $character->role !== GuildRoleEnum::VICE_LEADER) {
            return true;
        }
        return false;
    }

    public function invite(User $user, Guild $guild): bool
    {
        return $guild->isLeader($user) || $guild->isViceLeader($user);
    }
}
