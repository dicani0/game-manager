<?php

namespace App\Models\Poll;

use App\Enums\PollStatusEnum;
use App\Models\User;
use Database\Factories\Poll\PollFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Poll\Poll
 *
 * @property int                                $id
 * @property string                             $title
 * @property string|null                        $description
 * @property Carbon                             $start_date
 * @property Carbon                             $end_date
 * @property int|null                           $pollable_id
 * @property string|null                        $pollable_type
 * @property string                             $status
 * @property Carbon|null                        $created_at
 * @property Carbon|null                        $updated_at
 * @property-read Model|Eloquent                $pollable
 * @property-read Collection<int, PollQuestion> $questions
 * @property-read int|null                      $questions_count
 * @method static PollFactory factory($count = null, $state = [])
 * @method static Builder|Poll newModelQuery()
 * @method static Builder|Poll newQuery()
 * @method static Builder|Poll query()
 * @method static Builder|Poll whereCreatedAt($value)
 * @method static Builder|Poll whereDescription($value)
 * @method static Builder|Poll whereEndDate($value)
 * @method static Builder|Poll whereId($value)
 * @method static Builder|Poll wherePollableId($value)
 * @method static Builder|Poll wherePollableType($value)
 * @method static Builder|Poll whereStartDate($value)
 * @method static Builder|Poll whereStatus($value)
 * @method static Builder|Poll whereTitle($value)
 * @method static Builder|Poll whereUpdatedAt($value)
 * @property-read User|null $creator
 * @mixin Eloquent
 */
class Poll extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'status',
        'creator_id',
        'pollable_id',
        'pollable_type',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'status' => PollStatusEnum::class,
    ];

    public function pollable(): MorphTo
    {
        return $this->morphTo();
    }

    public function questions(): HasMany
    {
        return $this->hasMany(PollQuestion::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
