<?php

namespace App\Providers;

use App\Models\Character\Character;
use App\Models\Guild\Guild;
use App\Policies\CharacterPolicy;
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
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
    }
}
