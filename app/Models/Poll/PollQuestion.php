<?php

namespace App\Models\Poll;

use Database\Factories\Poll\PollQuestionFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Poll\PollQuestion
 *
 * @property int                                                                    $id
 * @property int                                                                    $poll_id
 * @property string                                                                 $question
 * @property string                                                                 $type
 * @property bool                                                                   $required
 * @property Carbon|null                                                            $created_at
 * @property Carbon|null                                                            $updated_at
 * @property-read Collection<int, PollQuestionAnswer> $answers
 * @property-read int|null                                                          $answers_count
 * @property-read Poll                                                              $poll
 * @method static PollQuestionFactory factory($count = null, $state = [])
 * @method static Builder|PollQuestion newModelQuery()
 * @method static Builder|PollQuestion newQuery()
 * @method static Builder|PollQuestion query()
 * @method static Builder|PollQuestion whereCreatedAt($value)
 * @method static Builder|PollQuestion whereId($value)
 * @method static Builder|PollQuestion wherePollId($value)
 * @method static Builder|PollQuestion whereQuestion($value)
 * @method static Builder|PollQuestion whereRequired($value)
 * @method static Builder|PollQuestion whereType($value)
 * @method static Builder|PollQuestion whereUpdatedAt($value)
 * @mixin Eloquent
 */
class PollQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'poll_id',
        'question',
        'description',
        'type',
        'required',
    ];

    protected $casts = [
        'required' => 'boolean',
    ];

    public function poll(): BelongsTo
    {
        return $this->belongsTo(Poll::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(PollQuestionAnswer::class);
    }
}
