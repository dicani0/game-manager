<?php

namespace App\Models\Market;

use App\Models\Items\Item;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Market\MarketOfferItem
 *
 * @property int $id
 * @property int $market_offer_id
 * @property int $cosmetic_id
 * @property int $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Item $cosmetic
 * @property-read \App\Models\Market\MarketOffer|null $offer
 * @method static \Illuminate\Database\Eloquent\Builder|MarketOfferItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MarketOfferItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MarketOfferItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|MarketOfferItem whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketOfferItem whereCosmeticId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketOfferItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketOfferItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketOfferItem whereMarketOfferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketOfferItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MarketOfferItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = true;

    public function offer(): BelongsTo
    {
        return $this->belongsTo(MarketOffer::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
