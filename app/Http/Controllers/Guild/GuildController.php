<?php

namespace App\Http\Controllers\Guild;

use App\Data\Guild\CreateGuildDto;
use App\Data\Guild\EditGuildDto;
use App\Data\Guild\InviteToGuildDto;
use App\Http\Controllers\Controller;
use App\Http\Resources\Guild\GuildResource;
use App\Models\Character\Character;
use App\Models\Guild\Guild;
use App\Models\Guild\GuildCharacter;
use App\Processes\Guild\CreateGuildProcess;
use App\Processes\Guild\EditGuildProcess;
use App\Processes\Guild\InviteToGuildProcess;
use App\Processes\Guild\KickFromGuildProcess;
use App\Queries\Guild\GuildIndexQuery;
use App\Queries\Guild\PossibleGuildMembersQuery;
use Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class GuildController extends Controller
{
    public function index(Request $request, GuildIndexQuery $query): Response
    {
        return Inertia::render('Guild/Guild', [
            'guilds' => GuildResource::collection($query->handle()->paginate()),
        ]);
    }

    public function show(Guild $guild): Response
    {
        return Inertia::render('Guild/GuildShow', [
            'guild' => GuildResource::make($guild->load('characters'))->withInvitations(),
            'characters' => Inertia::lazy(fn() => (new PossibleGuildMembersQuery())->handle($guild)->paginate(20)),
        ]);
    }

    public function create(): Response
    {
        Gate::allows('store', Guild::class);

        return Inertia::render('Guild/Create', [
            'characters' => Auth::user()->characters->map->only(['id', 'name']),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function store(CreateGuildDto $dto, CreateGuildProcess $process): RedirectResponse
    {
        $guild = $process->run($dto)->guild;

        return redirect('/guilds/' . $guild->name)->with('success', 'Guild created!');
    }

    /**
     * @throws Throwable
     */
    public function update(Guild $guild, EditGuildDto $dto, EditGuildProcess $process): RedirectResponse
    {
        $process->run($dto);

        return redirect('/guilds/' . $guild->name)->with('success', 'Guild updated!');
    }

    /**
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function kick(Guild $guild, GuildCharacter $member, KickFromGuildProcess $process)
    {
        $this->authorize('kick', [$guild, $member]);
        $process->run($member);

        return redirect('/guilds/' . $guild->name)->with('success', 'Member kicked!');
    }

    public function invite(InviteToGuildDto $dto, Guild $guild, Character $character, InviteToGuildProcess $process)
    {
        $process->run($dto);
        return redirect('/guilds/' . $dto->guild->name)->with('success', 'Member invited!');
    }

    public function delete()
    {

    }
}
