<?php

namespace App\Actions\Items;

use App\Data\Items\UpdateItemDto;
use App\Models\Cosmetics\UserCosmetic;

class UpdateItem
{
    public function handle(UserCosmetic $item, UpdateItemDto $dto): void
    {
        $item->update($dto->toArray());
    }
}
