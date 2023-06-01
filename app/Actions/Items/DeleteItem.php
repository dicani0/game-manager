<?php

namespace App\Actions\Items;

use App\Models\Cosmetics\UserCosmetic;

class DeleteItem
{
    public function handle(UserCosmetic $item): void
    {
        $item->delete();
    }
}
