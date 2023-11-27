<?php

namespace App\Queries\Guild;

use App\Models\Guild\Guild;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class GuildIndexQuery
{
    public function handle(): QueryBuilder
    {
        return QueryBuilder::for(Guild::class)
            ->allowedFilters([
                'recruiting',
                AllowedFilter::callback(
                    'my',
                    fn(Builder $query,) => $query->whereHas('characters',
                        fn(Builder $query) => $query->whereHas('character',
                            fn(Builder $query) => $query->where('user_id', auth()->id())
                        )
                    )
                ),
            ]);
    }
}