<?php

namespace App\Http\Controllers\Items;

use App\Http\Controllers\Controller;
use App\Http\Resources\Items\ItemResource;
use App\Queries\Item\ItemQuery;
use Inertia\Inertia;

class ItemController extends Controller
{
    public function index(ItemQuery $query)
    {
        return Inertia::render('Items/AllItems', [
            'items' => ItemResource::collection($query->handle()->get()
            ),
        ]);
    }
}
