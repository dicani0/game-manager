<?php

namespace App\Actions\Items;

use App\Data\Items\ImportItemsDto;
use App\Models\UserItem;

class SyncUserItems
{
    public function handle(ImportItemsDto $dto): void
    {
        $dto->items->each(function ($item) {
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
    }
}
