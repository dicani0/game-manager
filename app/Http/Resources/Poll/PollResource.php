<?php

namespace App\Http\Resources\Poll;

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
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
            $this->mergeWhen($this->withQuestions, [
                'questions' => PollQuestionResource::collection($this->questions),
            ]),
        ];
    }

    public function withQuestions(): self
    {
        $this->withQuestions = true;

        return $this;
    }
}
