<?php

namespace App\Http\Middleware;

use App\Http\Resources\Guild\GuildResourceCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'data' => fn () => $request->session()->get('data'),
            ],
            'notifications' => fn () => $request->user()?->unreadNotifications()->limit(10)->get(),
            'notifications_count' => fn () => $request->user()?->unreadNotifications()->count(),
            'auth' => [
                'user' => Auth::user()?->only('id', 'name', 'email', 'available_promotes'),
            ],
            'my_guilds' => Auth::user() ? new GuildResourceCollection(
                Auth::user()->characters->pluck('guildCharacter')
                    ->filter()
                    ->pluck('guild')->unique('id')
            ) : null,
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
        ]);
    }
}
