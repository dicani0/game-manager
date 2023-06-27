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
 * @property int $id
 * @property int $user_id
 * @property int $cosmetic_id
 * @property int $amount
 * @property int $used_amount
 * @property int $sold_amount
 * @property int $reserved_amount
 * @property int $bought_amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\Cosmetics\UserCosmeticFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|UserCosmetic whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCosmetic whereCosmeticId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCosmetic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCosmetic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCosmetic whereReservedAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCosmetic whereSoldAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCosmetic whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCosmetic whereUsedAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCosmetic whereUserId($value)
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
        'reserved_amount',
        'bought_amount',
    ];

    public function getAvailableAmountAttribute(): int
    {
        return $this->amount + $this->bought_amount - $this->used_amount - $this->sold_amount - $this->reserved_amount;
    }
}
