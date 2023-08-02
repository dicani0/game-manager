<?php

namespace App\Actions\Items;

use App\Data\Items\ImportItemsDto;
use App\Models\Items\Item;
use App\Models\Items\UserItem;

class SyncUserItems
{
    public function handle(ImportItemsDto $dto): void
    {
        $dto->items->each(function ($item) {
            $cosmetic = Item::query()->firstOrCreate(['name' => $item['item_name']]);
            UserItem::query()->updateOrCreate(
                [
                    'user_id' => $item['user_id'],
                    'item_id' => $cosmetic->getKey(),
                ],
                [
                    'amount' => $item['amount'],
                ]
            );
        });
    }
}
