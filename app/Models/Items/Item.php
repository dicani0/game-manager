<?php

namespace App\Models\Items;

use App\Models\User;
use Database\Factories\Items\ItemFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Items\Item
 *
 * @method static Builder|Item newModelQuery()
 * @method static Builder|Item newQuery()
 * @method static Builder|Item query()
 *
 * @property int                        $id
 * @property string                     $name
 * @property mixed|null                 $attributes
 * @property int                        $usable_amount
 *
 * @method static ItemFactory factory($count = null, $state = [])
 * @method static Builder|Item whereAttributes($value)
 * @method static Builder|Item whereId($value)
 * @method static Builder|Item whereName($value)
 * @method static Builder|Item whereUsableAmount($value)
 *
 * @property int                        $tier
 * @property int                        $power
 *
 * @method static Builder|Item wherePower($value)
 * @method static Builder|Item whereTier($value)
 *
 * @property-read Collection<int, User> $users
 * @property-read int|null              $users_count
 *
 * @method static Builder|Item userItems()
 * @method static Builder|Item userMissingItems()
 *
 * @mixin Eloquent
 */
class Item extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = ['id'];

    protected $casts = [
        'attributes' => 'array',
    ];

    /**
     * @return BelongsToMany<User>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(UserItem::class)
            ->withPivot('amount', 'reserved_amount');
    }

    public function scopeUserMissingItems(Builder $query): Builder
    {
        return $query->leftJoin('user_item', function ($join) {
            $join->on('items.id', '=', 'user_item.item_id')
                ->where('user_item.user_id', '=', request()->user()->id);
        })
            ->select(['items.*', 'user_item.amount as user_item_amount'])
            ->whereNull('user_item.amount')
            ->orderBy('name');
    }

    public function scopeUserItems(Builder $query): Builder
    {
        return $query->leftJoin('user_item', function ($join) {
            $join->on('items.id', '=', 'user_item.item_id')
                ->where('user_item.user_id', '=', request()->user()->id);
        })
            ->select(['items.*', 'user_item.amount as user_item_amount'])
            ->whereNotNull('user_item.amount')
            ->orderBy('name');
    }
}
