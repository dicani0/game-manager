<?php

namespace App\Http\Controllers\Guild;

use App\Data\Guild\InviteToGuildDto;
use App\Http\Controllers\Controller;
use App\Http\Resources\Guild\GuildInvitationResource;
use App\Models\Character\Character;
use App\Models\Guild\Guild;
use App\Models\Guild\GuildInvitation;
use App\Processes\Guild\AcceptGuildInviteProcess;
use App\Processes\Guild\CancelGuildInviteProcess;
use App\Processes\Guild\InviteToGuildProcess;
use App\Processes\Guild\RejectGuildInviteProcess;
use App\Queries\Guild\GuildInvitationQuery;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class GuildInvitationController extends Controller
{
    public function invites(Request $request, GuildInvitationQuery $query): Response
    {
        return Inertia::render('Guild/GuildInvites', [
            'invites' => GuildInvitationResource::collection($query->handle($request->user())->get()),
        ]
        );
    }

    /**
     * @throws Throwable
     */
    public function invite(InviteToGuildDto $dto, Guild $guild, Character $character, InviteToGuildProcess $process): RedirectResponse
    {
        $process->run($dto);

        return redirect('/guilds/'.$guild->name)->with('success', 'Member invited!');
    }

    /**
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function accept(GuildInvitation $guildInvitation, AcceptGuildInviteProcess $process): RedirectResponse
    {
        $this->authorize('accept', $guildInvitation);

        $process->run($guildInvitation);

        return redirect('/guilds/'.$guildInvitation->guild->name)->with('success', 'You have joined the guild');
    }

    /**
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function reject(GuildInvitation $guildInvitation, RejectGuildInviteProcess $process): RedirectResponse
    {
        $this->authorize('reject', $guildInvitation);

        $process->run($guildInvitation);

        return redirect('/guilds/'.$guildInvitation->guild->name)->with('success', 'You have rejected the invitation');
    }

    /**
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function cancel(GuildInvitation $guildInvitation, CancelGuildInviteProcess $process): RedirectResponse
    {
        $this->authorize('cancel', $guildInvitation);

        $process->run($guildInvitation);

        return redirect('/guilds/'.$guildInvitation->guild->name)->with('success', 'Invitation canceled!');
    }
}
