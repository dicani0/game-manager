<?php

namespace App\Actions\Items;

use App\Data\Items\UpdateItemData;
use App\Models\Cosmetics\UserCosmetic;

class UpdateItem
{
    public function handle(UserCosmetic $item, UpdateItemData $dto): void
    {
        $item->update($dto->toArray());
    }
}
