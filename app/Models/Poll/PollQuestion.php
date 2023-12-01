<?php

namespace App\Models\Poll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
