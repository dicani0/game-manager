<?php

namespace App\Models\Items;

use Database\Factories\Items\UserItemFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Carbon;

/**
 * App\Models\Items\UserItem
 *
 * @property-read int $available_amount
 * @method static Builder|UserItem newModelQuery()
 * @method static Builder|UserItem newQuery()
 * @method static Builder|UserItem query()
 * @property int $id
 * @property int $user_id
 * @property int $item_id
 * @property int $amount
 * @property int $used_amount
 * @property int $sold_amount
 * @property int $reserved_amount
 * @property int $bought_amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static UserItemFactory factory($count = null, $state = [])
 * @method static Builder|UserItem whereAmount($value)
 * @method static Builder|UserItem whereBoughtAmount($value)
 * @method static Builder|UserItem whereCreatedAt($value)
 * @method static Builder|UserItem whereId($value)
 * @method static Builder|UserItem whereItemId($value)
 * @method static Builder|UserItem whereReservedAmount($value)
 * @method static Builder|UserItem whereSoldAmount($value)
 * @method static Builder|UserItem whereUpdatedAt($value)
 * @method static Builder|UserItem whereUsedAmount($value)
 * @method static Builder|UserItem whereUserId($value)
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
