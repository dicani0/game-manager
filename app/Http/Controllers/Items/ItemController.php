<?php

namespace App\Http\Controllers\Items;

use App\Http\Controllers\Controller;
use App\Http\Requests\Items\SyncItemsRequest;
use App\Models\UserItem;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Items/Item', [
            'items' => $request->user()->items,
        ]);
    }

    public function sync(SyncItemsRequest $request)
    {
        //TODO move all logic to action classes
        $userId = $request->user()->getKey();
        $content = $request->validated()['content'];

        $lines = Str::of($content)->explode("\n");

        $data = $lines->map(function ($line) use ($userId) {
            $parts = Str::of($line)->trim()->explode('x', 2);
            $amount = Str::of(Arr::get($parts, 0))->trim();
            $name = Str::of(Arr::get($parts, 1))->before("\t")->before('(P')->trim();
            return [
                'amount' => $amount->toInteger(),
                'item_name' => $name->toString(),
                'user_id' => $userId,
            ];
        });
        $data->each(function ($item) {
            UserItem::query()->updateOrCreate(
                [
                    'user_id' => $item['user_id'],
                    'item_name' => $item['item_name'],
                ],
                [
                    'amount' => $item['amount'],
                ]
            );
        });

        return Inertia::render('Items/Item', [
            'items' => $request->user()->items,
        ]);
    }
}
