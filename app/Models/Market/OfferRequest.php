<?php

namespace App\Models\Market;

use App\Models\Cosmetics\Cosmetic;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * App\Models\Market\OfferRequest
 *
 * @property-read Model|\Eloquent $offerable
 * @method static \Illuminate\Database\Eloquent\Builder|OfferRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OfferRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OfferRequest query()
 * @property int $id
 * @property string $offerable_type
 * @property int $offerable_id
 * @property int $user_id
 * @property int|null $at_price
 * @property int|null $lat_price
 * @property string $status
 * @property string $type
 * @property string|null $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Cosmetic> $cosmetics
 * @property-read int|null $cosmetics_count
 * @property-read User $creator
 * @method static \Illuminate\Database\Eloquent\Builder|OfferRequest whereAtPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfferRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfferRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfferRequest whereLatPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfferRequest whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfferRequest whereOfferableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfferRequest whereOfferableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfferRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfferRequest whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfferRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfferRequest whereUserId($value)
 * @mixin \Eloquent
 */
class OfferRequest extends Model
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

    public function cosmetics(): BelongsToMany
    {
        return $this->belongsToMany(
            Cosmetic::class,
            'offer_request_item',
            'offer_request_id',
            'cosmetic_id'
        )->withPivot('amount');
    }
}
