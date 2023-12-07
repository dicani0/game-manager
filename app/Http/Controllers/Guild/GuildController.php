<?php

namespace App\Http\Controllers\Guild;

use App\Data\Guild\CreateGuildDto;
use App\Data\Guild\EditGuildDto;
use App\Http\Controllers\Controller;
use App\Http\Resources\Guild\GuildResource;
use App\Models\Guild\Guild;
use App\Models\Guild\GuildCharacter;
use App\Models\User;
use App\Processes\Guild\CreateGuildProcess;
use App\Processes\Guild\DeleteGuildProcess;
use App\Processes\Guild\EditGuildProcess;
use App\Processes\Guild\KickFromGuildProcess;
use App\Queries\Guild\GuildIndexQuery;
use App\Queries\Guild\PossibleGuildMembersQuery;
use Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class GuildController extends Controller
{
    public function index(GuildIndexQuery $query): Response
    {
        return Inertia::render('Guild/Guild', [
            'guilds' => GuildResource::collection($query->handle()->paginate()),
        ]);
    }

    public function show(Guild $guild): Response
    {
        $user = Auth::user();

        return Inertia::render('Guild/GuildShow', [
            'guild' => GuildResource::make($guild->load('characters'))->withInvitations(),
            'characters' => Inertia::lazy(fn () => (new PossibleGuildMembersQuery())->handle($guild)->paginate(20)),
            'can' => [
                'edit' => $user->can('update', $guild),
                'invite' => $user->can('invite', $guild),
                'cancel-invitation' => $user->can('invite', $guild),
            ],
        ]);
    }

    public function create(): Response
    {
        Gate::allows('store', Guild::class);

        /** @var User $user */
        $user = Auth::user();

        return Inertia::render('Guild/Create', [
            'characters' => $user->characters->map->only(['id', 'name']),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function store(CreateGuildDto $dto, CreateGuildProcess $process): RedirectResponse
    {
        $guild = $process->run($dto)->guild;

        return redirect('/guilds/'.$guild->name)->with('success', 'Guild created!');
    }

    /**
     * @throws Throwable
     */
    public function update(Guild $guild, EditGuildDto $dto, EditGuildProcess $process): RedirectResponse
    {
        $process->run($dto);

        return redirect('/guilds/'.$guild->name)->with('success', 'Guild updated!');
    }

    /**
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function kick(Guild $guild, GuildCharacter $member, KickFromGuildProcess $process): RedirectResponse
    {
        $this->authorize('kick', [$guild, $member]);
        $process->run($member);

        return redirect('/guilds/'.$guild->name)->with('success', 'Member kicked!');
    }

    /**
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function delete(Guild $guild, DeleteGuildProcess $process): RedirectResponse
    {
        $this->authorize('delete', $guild);

        $process->run($guild);

        return redirect('/guilds')->with('success', 'Guild deleted!');
    }
}
