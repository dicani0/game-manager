<?php

namespace App\Http\Controllers\Poll;

use App\Data\Poll\CreatePollDto;
use App\Data\Poll\UpdatePollDto;
use App\Http\Controllers\Controller;
use App\Http\Resources\Poll\PollResource;
use App\Models\Poll\Poll;
use App\Processes\Poll\CreatePollProcess;
use App\Queries\Poll\GlobalPollsQuery;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class PollController extends Controller
{
    public function index(GlobalPollsQuery $query): Response
    {
        return Inertia::render('Poll/GlobalPolls', [
            'polls' => PollResource::collection($query->handle()->paginate(10)),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Poll/CreatePollForm');
    }

    /**
     * @throws Throwable
     */
    public function store(CreatePollDto $dto, CreatePollProcess $process): RedirectResponse
    {
        $process->run($dto);

        return redirect()->to('/polls')->with('success', 'Poll created successfully.');
    }

    public function edit(Poll $poll): Response
    {
        return Inertia::render('Poll/EditPollForm', [
            'poll' => PollResource::make($poll)->withQuestions(),
        ]);
    }

    public function update(Poll $poll, UpdatePollDto $dto): RedirectResponse
    {
        dd($dto);
        return redirect()->to('/polls')->with('success', 'Poll updated successfully.');
    }
}