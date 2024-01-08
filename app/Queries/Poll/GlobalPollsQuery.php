<?php

namespace App\Queries\Poll;

use App\Models\Poll\Poll;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\QueryBuilder;

class GlobalPollsQuery
{
    public function handle(): QueryBuilder|Builder
    {
        return QueryBuilder::for(Poll::class)
            ->allowedIncludes(['questions', 'questions.answers'])
            ->allowedFilters([])
            ->whereNull('pollable_id')
            ->whereNull('pollable_type');
    }
}
