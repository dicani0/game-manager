<?php

namespace App\Http\Resources\Poll;

use App\Models\Poll\Vote;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Vote */
class VoteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'poll_question_id' => $this->poll_question_id,
            'poll_question_answer_id' => $this->poll_question_answer_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'user_id' => $this->user_id,
        ];
    }
}
