<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserItem
 *
 * @property int $id
 * @property int $user_id
 * @property string $item_name
 * @property int $amount
 * @property int $used_amount
 * @property int $sold_amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $available_amount
 * @method static \Database\Factories\UserItemFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|UserItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserItem whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserItem whereItemName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserItem whereSoldAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserItem whereUsedAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserItem whereUserId($value)
 * @mixin \Eloquent
 */
class UserItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_name',
        'amount',
        'available_amount',
        'used_amount',
        'sold_amount',
    ];

    public function getAvailableAmountAttribute()
    {
        return $this->amount - $this->used_amount - $this->sold_amount;
    }
}
