<?php

namespace App\Models\Poll;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
