<?php

namespace App\Models\Poll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
