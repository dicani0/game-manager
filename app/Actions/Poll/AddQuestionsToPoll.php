<?php

namespace App\Actions\Poll;

use App\Data\Poll\CreateQuestionDto;
use App\Models\Poll\Poll;
use Spatie\LaravelData\DataCollection;

class AddQuestionsToPoll
{
    public function handle(Poll $poll, DataCollection $questions): Poll
    {
        $questions->each(function (CreateQuestionDto $questionDto) use ($poll) {
            $questionDto->pollQuestion = $poll->questions()->create($questionDto->toArray() + [
                    'poll_id' => $poll->id,
                ]);
        });
        return $poll->refresh();
    }
}
