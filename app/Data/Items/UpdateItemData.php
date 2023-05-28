<?php

namespace App\Data\Items;

use Spatie\LaravelData\Data;

class UpdateItemData extends Data
{
    public int $amount;
    public int $sold_amount;
    public int $used_amount;
}
