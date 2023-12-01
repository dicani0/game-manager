<?php

namespace App\Actions\Poll;

use App\Models\Poll\PollQuestion;
use Spatie\LaravelData\DataCollection;

class AddAnswersToQuestion
{
    public function handle(PollQuestion $question, DataCollection $answers): void
    {
        $question->answers()->createMany($answers->toArray());
    }
}
