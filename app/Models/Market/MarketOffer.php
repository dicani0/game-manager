<?php

namespace App\Models\Market;

use App\Enums\MarketOfferStatusEnum;
use App\Models\Interfaces\Offerable as OfferableInterface;
use App\Models\User;
use App\Traits\Offerable;
use Database\Factories\Market\MarketOfferFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Market\MarketOffer
 *
 * @property int                                   $id
 * @property int                                   $user_id
 * @property string                                $type
 * @property string                                $expires_at
 * @property int                                   $promoted
 * @property int|null                              $at_price
 * @property int|null                              $lat_price
 * @property string|null                           $description
 * @property string                                $status
 * @property Carbon|null                           $created_at
 * @property Carbon|null                           $updated_at
 * @property-read Collection<int, MarketOfferItem> $items
 * @property-read int|null                         $items_count
 * @property-read Collection<int, TradeOffer>      $offers
 * @property-read int|null                         $offers_count
 * @property-read User                             $user
 * @method static MarketOfferFactory factory($count = null, $state = [])
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
 * @mixin Eloquent
 */
class MarketOffer extends Model implements OfferableInterface
{
    use HasFactory, Offerable;

    protected $guarded = [];

    protected $casts = [
        'status' => MarketOfferStatusEnum::class,
        'expires_at' => 'datetime',
    ];

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
