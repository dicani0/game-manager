<?php

namespace App\Models\Market;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * App\Models\Market\MarketOffer
 *
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property string $expires_at
 * @property int $promoted
 * @property int|null $at_price
 * @property int|null $lat_price
 * @property string|null $description
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Market\MarketOfferItem> $items
 * @property-read int|null $items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Market\TradeOffer> $offers
 * @property-read int|null $offers_count
 * @property-read User $user
 * @method static \Database\Factories\Market\MarketOfferFactory factory($count = null, $state = [])
 * @method static Builder|MarketOffer maxAtPrice(int $value)
 * @method static Builder|MarketOffer maxLatPrice(int $value)
 * @method static Builder|MarketOffer newModelQuery()
 * @method static Builder|MarketOffer newQuery()
 * @method static Builder|MarketOffer query()
 * @method static Builder|MarketOffer whereAtPrice($value)
 * @method static Builder|MarketOffer whereCreatedAt($value)
 * @method static Builder|MarketOffer whereDescription($value)
 * @method static Builder|MarketOffer whereExpiresAt($value)
 * @method static Builder|MarketOffer whereId($value)
 * @method static Builder|MarketOffer whereLatPrice($value)
 * @method static Builder|MarketOffer wherePromoted($value)
 * @method static Builder|MarketOffer whereStatus($value)
 * @method static Builder|MarketOffer whereType($value)
 * @method static Builder|MarketOffer whereUpdatedAt($value)
 * @method static Builder|MarketOffer whereUserId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Market\MarketOfferItem> $items
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Market\TradeOffer> $offers
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Market\MarketOfferItem> $items
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Market\TradeOffer> $offers
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

    public function offers(): MorphMany
    {
        return $this->morphMany(TradeOffer::class, 'offerable');
    }

    public function scopeMaxLatPrice(Builder $query, int $value)
    {
        return $query->where('lat_price', '<=', $value);
    }

    public function scopeMaxAtPrice(Builder $query, int $value)
    {
        return $query->where('at_price', '<=', $value);
    }
}
