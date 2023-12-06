<?php

namespace App\Http\Controllers\Items;

use App\Http\Controllers\Controller;
use App\Http\Resources\Items\ItemResource;
use App\Models\Items\Item;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Items/AllItems', [
            'items' => ItemResource::collection(Item::query()->orderBy('name')->get()),
        ]);
    }
}
