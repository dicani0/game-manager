<?php

namespace App\Models\Poll;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Poll\PollQuestionAnswer
 *
 * @property int                             $id
 * @property int                             $poll_question_id
 * @property string                          $content
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read PollQuestion|null          $question
 *
 * @method static Builder|PollQuestionAnswer newModelQuery()
 * @method static Builder|PollQuestionAnswer newQuery()
 * @method static Builder|PollQuestionAnswer query()
 * @method static Builder|PollQuestionAnswer whereContent($value)
 * @method static Builder|PollQuestionAnswer whereCreatedAt($value)
 * @method static Builder|PollQuestionAnswer whereId($value)
 * @method static Builder|PollQuestionAnswer wherePollQuestionId($value)
 * @method static Builder|PollQuestionAnswer whereUpdatedAt($value)
 * @method static \Database\Factories\Poll\PollQuestionAnswerFactory factory($count = null, $state = [])
 *
 * @mixin Eloquent
 */
class PollQuestionAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'poll_question_id',
        'content',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(PollQuestion::class);
    }
}
