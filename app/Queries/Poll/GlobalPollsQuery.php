<?php

namespace App\Queries\Poll;

use App\Models\Poll\Poll;
use Spatie\QueryBuilder\QueryBuilder;

class GlobalPollsQuery
{
    public function handle(): QueryBuilder
    {
        return QueryBuilder::for(Poll::class)
            ->allowedFilters([]);
    }
}