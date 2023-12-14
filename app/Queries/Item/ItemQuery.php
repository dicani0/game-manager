<?php

namespace App\Queries\Item;

use App\Models\Items\Item;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ItemQuery
{
    public function handle(): QueryBuilder
    {
        return QueryBuilder::for(Item::class)
            ->allowedFilters([
                AllowedFilter::scope('user_missing_items'),
                AllowedFilter::scope('user_items'),
            ]);
    }
}
