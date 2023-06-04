<?php

namespace App\Models\Market;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Market\MarketOffer
 *
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property string $expires_at
 * @property int $promoted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Market\MarketOfferItem> $items
 * @property-read int|null $items_count
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|MarketOffer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MarketOffer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MarketOffer query()
 * @method static \Illuminate\Database\Eloquent\Builder|MarketOffer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketOffer whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketOffer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketOffer wherePromoted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketOffer whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketOffer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketOffer whereUserId($value)
 * @mixin \Eloquent
 */
class MarketOffer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(MarketOfferItem::class);
    }
}
