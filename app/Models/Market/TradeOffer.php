<?php

namespace App\Models\Market;

use App\Models\Items\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * App\Models\Market\TradeOffer
 *
 * @property-read User $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Item> $items
 * @property-read int|null $items_count
 * @property-read Model|\Eloquent $offerable
 * @method static \Illuminate\Database\Eloquent\Builder|TradeOffer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TradeOffer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TradeOffer query()
 * @mixin \Eloquent
 */
class TradeOffer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function offerable(): MorphTo
    {
        return $this->morphTo();
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(
            Item::class,
            'trade_offer_item',
            'trade_offer_id',
            'item_id'
        )->withPivot('amount');
    }
}
