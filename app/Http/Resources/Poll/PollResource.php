<?php

namespace App\Http\Resources\Poll;

use App\Models\Poll\Poll;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PollResource extends JsonResource
{
    public bool $withQuestions = false;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getResource()->getKey(),
            'title' => $this->getResource()->title,
            'description' => $this->getResource()->description,
            'start_date' => $this->getResource()->start_date,
            'end_date' => $this->getResource()->end_date,
            'status' => $this->getResource()->status,
            $this->mergeWhen($this->withQuestions, [
                'questions' => PollQuestionResource::collection($this->getResource()->questions),
            ]),
        ];
    }

    public function withQuestions(): self
    {
        $this->withQuestions = true;

        return $this;
    }

    public function getResource(): Poll
    {
        return $this->resource;
    }
}
