<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
}
