<?php

namespace App\Http\Controllers\Poll;

use App\Data\Poll\Voting\PollVotingDto;
use App\Http\Controllers\Controller;
use App\Http\Resources\Poll\PollResource;
use App\Models\Poll\Poll;
use App\Processes\Poll\SubmitVotesProcess;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class PollVotingController extends Controller
{
    /**
     * @throws Throwable
     */
    public function vote(PollVotingDto $dto, Poll $poll, SubmitVotesProcess $process)
    {
        $dto->user = auth()->user();
        $process->run($dto);

        return redirect()->back()->with('success', 'Your votes have been submitted.');
    }

    public function results(Poll $poll): Response
    {
        $poll->load('questions.answers.votes');

        return Inertia::render('Poll/PollResults', [
            'poll' => PollResource::make($poll)->withQuestions(),
        ]);
    }
}
