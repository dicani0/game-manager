<?php

namespace App\Providers;

use App\Models\Character\Character;
use App\Models\Guild\Guild;
use App\Models\Guild\GuildInvitation;
use App\Policies\CharacterPolicy;
use App\Policies\GuildInvitationPolicy;
use App\Policies\GuildPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
    }
}
