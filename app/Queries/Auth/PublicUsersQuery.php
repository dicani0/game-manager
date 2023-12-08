<?php

namespace App\Queries\Auth;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class PublicUsersQuery
{

    public function handle(): QueryBuilder|Builder
    {
        return QueryBuilder::for(User::class)
            ->where('private', false)
            ->where('id', '!=', Auth::id());
    }
}
