<?php

namespace App\Actions\Items;

use App\Data\Items\UpdateItemDto;
use App\Models\Items\UserItem;

class UpdateItem
{
    public function handle(UserItem $item, UpdateItemDto $dto): void
    {
        $item->update($dto->toArray());
    }
}
