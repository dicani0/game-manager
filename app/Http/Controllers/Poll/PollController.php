<?php

namespace App\Http\Controllers\Poll;

use App\Data\Poll\CreatePollDto;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class PollController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Guild/Poll/Index', [
            'polls' => auth()->user()->guild->polls()->with('questions.answers')->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Guild/Poll/Create');
    }

    public function store(CreatePollDto $dto): RedirectResponse
    {
        dd($dto->toArray());
        auth()->user()->guild->polls()->create(request()->validate([
            'title' => 'required',
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]));

        return redirect()->back();
    }
}
