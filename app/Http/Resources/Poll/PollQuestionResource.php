<?php

namespace App\Http\Resources\Poll;

use App\Models\Poll\PollQuestion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PollQuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getResource()->getKey(),
            'question' => $this->getResource()->question,
            'type' => $this->getResource()->type,
            'answers' => PollQuestionAnswerResource::collection($this->getResource()->answers),
        ];
    }

    private function getResource(): PollQuestion
    {
        return $this->resource;
    }
}
