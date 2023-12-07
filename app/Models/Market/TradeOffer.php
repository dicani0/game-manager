<?php

namespace App\Models\Market;

use App\Enums\MarketOfferRequestStatusEnum;
use App\Enums\OfferTypeEnum;
use App\Models\Items\Item;
use App\Models\User;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Market\TradeOffer
 *
 * @property-read User                    $creator
 * @property-read Collection<int, Item>   $items
 * @property-read int|null                $items_count
 * @property-read User|MarketOffer        $offerable
 *
 * @method static Builder|TradeOffer newModelQuery()
 * @method static Builder|TradeOffer newQuery()
 * @method static Builder|TradeOffer query()
 *
 * @property int                          $id
 * @property string                       $offerable_type
 * @property int                          $offerable_id
 * @property int                          $user_id
 * @property int|null                     $at_price
 * @property int|null                     $lat_price
 * @property MarketOfferRequestStatusEnum $status
 * @property OfferTypeEnum                $type
 * @property string|null                  $message
 * @property Carbon|null                  $created_at
 * @property Carbon|null                  $updated_at
 *
 * @method static Builder|TradeOffer whereAtPrice($value)
 * @method static Builder|TradeOffer whereCreatedAt($value)
 * @method static Builder|TradeOffer whereId($value)
 * @method static Builder|TradeOffer whereLatPrice($value)
 * @method static Builder|TradeOffer whereMessage($value)
 * @method static Builder|TradeOffer whereOfferableId($value)
 * @method static Builder|TradeOffer whereOfferableType($value)
 * @method static Builder|TradeOffer whereStatus($value)
 * @method static Builder|TradeOffer whereType($value)
 * @method static Builder|TradeOffer whereUpdatedAt($value)
 * @method static Builder|TradeOffer whereUserId($value)
 *
 * @mixin Eloquent
 * @mixin \Eloquent
 */
class TradeOffer extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'type' => OfferTypeEnum::class,
        'status' => MarketOfferRequestStatusEnum::class,
    ];

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
