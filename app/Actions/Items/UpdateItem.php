<?php

namespace App\Actions\Items;

use App\Data\Items\UpdateItemData;
use App\Models\UserItem;

class UpdateItem
{
    public function handle(UserItem $item, UpdateItemData $dto): void
    {
        $item->update($dto->toArray());
    }
}
