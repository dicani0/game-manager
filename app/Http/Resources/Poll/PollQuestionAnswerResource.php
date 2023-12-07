<?php

namespace App\Http\Resources\Poll;

use App\Models\Poll\PollQuestionAnswer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PollQuestionAnswerResource extends JsonResource
{
    /**
     * @var PollQuestionAnswer
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->getKey(),
            'content' => $this->resource->content,
        ];
    }
}
