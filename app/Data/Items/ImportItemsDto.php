<?php

namespace App\Data\Items;

use App\Models\User;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

class ImportItemsDto extends Data
{
    public string $content;

    public ?User $user = null;

    public ?Collection $items = null;
}
