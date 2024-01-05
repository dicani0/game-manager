<?php

namespace App\Http\Controllers\Poll;

use App\Data\Poll\CreatePollDto;
use App\Data\Poll\UpdatePollDto;
use App\Http\Controllers\Controller;
use App\Http\Resources\Poll\PollResource;
use App\Models\Poll\Poll;
use App\Processes\Poll\CreatePollProcess;
use App\Processes\Poll\UpdatePollProcess;
use App\Queries\Poll\GlobalPollsQuery;
use Auth;
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
            'can' => [
                'create' => Auth::user()?->hasRole('admin'),
                'update' => Auth::user()?->hasRole('admin'),
            ],
        ]);
    }

    public function show(Poll $poll)
    {
        return Inertia::render('Poll/Poll', [
            'poll' => PollResource::make($poll)->withQuestions(),
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

    /**
     * @throws Throwable
     */
    public function update(Poll $poll, UpdatePollDto $dto, UpdatePollProcess $process): RedirectResponse
    {
        $process->run($dto);

        return redirect()->to('/polls')->with('success', 'Poll updated successfully.');
    }
}
