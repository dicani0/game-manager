<?php

namespace App\Http\Controllers\Poll;

use App\Data\Poll\CreatePollDto;
use App\Http\Controllers\Controller;
use App\Processes\Poll\CreatePollProcess;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class PollController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Poll/GlobalPolls', [
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

        return redirect()->to('/polls');
    }
}
