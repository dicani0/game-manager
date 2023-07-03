<?php

namespace App\Models\Items;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\Items\UserItem
 *
 * @property-read int $available_amount
 * @method static \Illuminate\Database\Eloquent\Builder|UserItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserItem query()
 * @mixin \Eloquent
 */
class UserItem extends Pivot
{
    use HasFactory;

    public $incrementing = true;

    protected $fillable = [
        'user_id',
        'item_id',
        'amount',
        'available_amount',
        'used_amount',
        'sold_amount',
        'reserved_amount',
        'bought_amount',
    ];

    public function getAvailableAmountAttribute(): int
    {
        return $this->amount + $this->bought_amount - $this->used_amount - $this->sold_amount - $this->reserved_amount;
    }
}
