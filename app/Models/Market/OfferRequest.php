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
