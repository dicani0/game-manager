<?php

namespace App\Http\Controllers\Guild;

use App\Http\Controllers\Controller;
use App\Http\Resources\Guild\GuildResource;
use App\Http\Resources\Poll\PollResource;
use App\Models\Guild\Guild;
use App\Queries\Poll\GuildPollsQuery;
use Inertia\Inertia;
use Inertia\Response;

class GuildPollController extends Controller
{
    public function index(Guild $guild, GuildPollsQuery $query): Response
    {
        return Inertia::render('Guild/GuildPolls', [
            'polls' => PollResource::collection($query->handle($guild)->paginate()),
            'can' => [
                'create' => true,
                'update' => true,
            ],
        ]);
    }

    public function create(Guild $guild): Response
    {
        return Inertia::render('Guild/CreateGuildPollForm', [
            'guild' => GuildResource::make($guild),
        ]);
    }
}
