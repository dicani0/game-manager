<?php

namespace App\Models\Poll;

use App\Models\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Poll\Vote
 *
 * @property int                          $id
 * @property int                          $user_id
 * @property int                          $poll_question_id
 * @property int                          $poll_question_answer_id
 * @property Carbon|null                  $created_at
 * @property Carbon|null                  $updated_at
 * @property-read PollQuestionAnswer|null $answer
 * @property-read PollQuestion|null       $question
 * @property-read User                    $user
 *
 * @method static Builder|Vote newModelQuery()
 * @method static Builder|Vote newQuery()
 * @method static Builder|Vote query()
 * @method static Builder|Vote whereCreatedAt($value)
 * @method static Builder|Vote whereId($value)
 * @method static Builder|Vote wherePollQuestionAnswerId($value)
 * @method static Builder|Vote wherePollQuestionId($value)
 * @method static Builder|Vote whereUpdatedAt($value)
 * @method static Builder|Vote whereUserId($value)
 *
 * @mixin Eloquent
 */
class Vote extends Model
{
    protected $fillable = [
        'poll_question_answer_id',
        'poll_question_id',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(PollQuestion::class);
    }

    public function answer(): BelongsTo
    {
        return $this->belongsTo(PollQuestionAnswer::class);
    }
}
