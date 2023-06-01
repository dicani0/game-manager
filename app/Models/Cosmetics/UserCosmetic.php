<?php

namespace App\Models\Cosmetics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\Cosmetics\UserCosmetic
 *
 * @property-read int $available_amount
 * @method static \Illuminate\Database\Eloquent\Builder|UserCosmetic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCosmetic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCosmetic query()
 * @mixin \Eloquent
 */
class UserCosmetic extends Pivot
{
    use HasFactory;

    public $incrementing = true;

    protected $fillable = [
        'user_id',
        'cosmetic_id',
        'amount',
        'available_amount',
        'used_amount',
        'sold_amount',
    ];

    public function getAvailableAmountAttribute(): int
    {
        return $this->amount - $this->used_amount - $this->sold_amount;
    }
}
