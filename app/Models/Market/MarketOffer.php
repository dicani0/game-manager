<?php

namespace App\Models\Market;

use App\Models\User;
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
 * @property string $status
 * @method static \Illuminate\Database\Eloquent\Builder|MarketOffer whereStatus($value)
 * @property int|null $at_price
 * @property int|null $lat_price
 * @property string|null $description
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Market\OfferRequest> $offers
 * @property-read int|null $offers_count
 * @method static \Database\Factories\Market\MarketOfferFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|MarketOffer maxAtPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketOffer maxLatPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketOffer whereAtPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketOffer whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketOffer whereLatPrice($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Market\MarketOfferItem> $items
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Market\OfferRequest> $offers
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
        return $this->morphMany(OfferRequest::class, 'offerable');
    }

    public function scopeMaxLatPrice($query, $value)
    {
        return $query->where('lat_price', '<=', $value);
    }

    public function scopeMaxAtPrice($query, $value)
    {
        return $query->where('at_price', '<=', $value);
    }
}
