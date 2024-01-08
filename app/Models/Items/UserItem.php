<?php

namespace App\Models\Items;

use App\Models\User;
use Database\Factories\Items\UserItemFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Carbon;

/**
 * App\Models\Items\UserItem
 *
 * @property-read int    $available_amount
 *
 * @method static Builder|UserItem newModelQuery()
 * @method static Builder|UserItem newQuery()
 * @method static Builder|UserItem query()
 *
 * @property int         $id
 * @property int         $user_id
 * @property int         $item_id
 * @property int         $amount
 * @property int         $used_amount
 * @property int         $sold_amount
 * @property int         $reserved_amount
 * @property int         $bought_amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
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
 *
 * @property-read Item   $item
 * @property-read User   $user
 *
 * @method static Builder|UserItem sellable()
 *
 * @mixin Eloquent
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

    /**
     * @return BelongsTo<User, UserItem>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Item, UserItem>
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function scopeSellable(Builder $query): Builder
    {
        return $query->where('amount', '>', 1);
    }
}
