<?php

namespace App\Providers;

use App\Models\Character\Character;
use App\Models\Guild\Guild;
use App\Models\Guild\GuildInvitation;
use App\Models\Poll\Poll;
use App\Policies\CharacterPolicy;
use App\Policies\GuildInvitationPolicy;
use App\Policies\GuildPolicy;
use App\Policies\NotificationPolicy;
use App\Policies\Poll\PollPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\DatabaseNotification;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Character::class => CharacterPolicy::class,
        Guild::class => GuildPolicy::class,
        GuildInvitation::class => GuildInvitationPolicy::class,
        DatabaseNotification::class => NotificationPolicy::class,
        Poll::class => PollPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
    }
}
