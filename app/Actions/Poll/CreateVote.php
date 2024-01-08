<?php

namespace App\Actions\Poll;

use App\Models\Poll\Poll;
use App\Models\Poll\PollQuestion;
use App\Models\Poll\PollQuestionAnswer;
use App\Models\Poll\Vote;
use App\Models\User;

class CreateVote
{
    public function handle(User $user, Poll $poll, PollQuestion $pollQuestion, PollQuestionAnswer $pollQuestionAnswer): Vote
    {
        return Vote::create([
            'user_id' => $user->getKey(),
            'poll_id' => $poll->getKey(),
            'poll_question_id' => $pollQuestion->getKey(),
            'poll_question_answer_id' => $pollQuestionAnswer->getKey(),
        ]);
    }
}
