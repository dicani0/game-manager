<?php

namespace App\Queries\Poll;

use App\Models\Guild\Guild;
use App\Models\Poll\Poll;
use Illuminate\Database\Eloquent\Builder;

class GuildPollsQuery
{
    public function handle(Guild $guild): Builder
    {
        return Poll::where([
            'pollable_type' => Guild::class,
            'pollable_id' => $guild->getKey(),
        ]);
    }
}
