<?php

namespace App\Policies;

use App\Models\Guild\Guild;
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
}
