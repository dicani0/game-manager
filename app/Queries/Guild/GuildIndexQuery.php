<?php

namespace App\Queries\Guild;

use App\Models\Guild\Guild;
use Spatie\QueryBuilder\QueryBuilder;

class GuildIndexQuery
{
    public function handle(): QueryBuilder
    {
        return QueryBuilder::for(Guild::class)
            ->allowedFilters([
                'recruiting',
            ]);
    }
}