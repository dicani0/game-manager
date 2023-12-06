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

            $userItem = UserItem::query()->firstOrNew(
                [
                    'user_id' => $item['user_id'],
                    'item_id' => $cosmetic->getKey(),
                ]
            );

            if ($userItem->exists) {
                $userItem->increment('amount', $item['amount']);
            } else {
                $userItem->amount = $item['amount'];
                $userItem->save();
            }
        });
    }
}
