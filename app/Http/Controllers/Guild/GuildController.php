<?php

namespace App\Http\Controllers\Guild;

use App\Data\Guild\CreateGuildDto;
use App\Http\Controllers\Controller;
use App\Http\Resources\Guild\GuildResource;
use App\Processes\Guild\CreateGuildProcess;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class GuildController extends Controller
{
    public function dashboard(Request $request): Response
    {
        return Inertia::render('Guild/Guild', [
            'guild' => $request->user()?->guild()?->with('users'),
        ]);
    }

    public function show(): Response
    {
        return Inertia::render('Guild/Guild');
    }

    public function create(): Response
    {
        return Inertia::render('Guild/Create');
    }

    /**
     * @throws Throwable
     */
    public function store(CreateGuildDto $dto, CreateGuildProcess $process): Response
    {
        $guild = $process->run($dto)->guild;

        return Inertia::render('Guild/Guild', ['guild' => GuildResource::make($guild)]);
    }
}
