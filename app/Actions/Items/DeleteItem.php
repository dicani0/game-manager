<?php

namespace App\Actions\Items;

use App\Models\UserItem;

class DeleteItem
{
    public function handle(UserItem $item): void
    {
        $item->delete();
    }
}
