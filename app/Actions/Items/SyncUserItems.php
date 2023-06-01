<?php

namespace App\Actions\Items;

use App\Data\Items\ImportItemsDto;
use App\Models\Cosmetics\Cosmetic;
use App\Models\Cosmetics\UserCosmetic;

class SyncUserItems
{
    public function handle(ImportItemsDto $dto): void
    {
        $dto->items->each(function ($item) {
            $cosmetic = Cosmetic::query()->firstOrCreate(['name' => $item['item_name']]);
            UserCosmetic::query()->updateOrCreate(
                [
                    'user_id' => $item['user_id'],
                    'cosmetic_id' => $cosmetic->getKey(),
                ],
                [
                    'amount' => $item['amount'],
                ]
            );
        });
    }
}
