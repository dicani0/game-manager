<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\UpdateSettings;
use App\Data\Auth\SettingsData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SettingsRequest;
use App\Http\Requests\Auth\UpdateSettingsRequest;
use App\Http\Resources\Auth\SettingsResource;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class SettingsController extends Controller
{
    public function get(SettingsRequest $request): Response
    {
        return Inertia::render('Auth/Settings', [
            'user' => SettingsResource::make($request->user()),
        ]);
    }

    public function patch(UpdateSettingsRequest $request, UpdateSettings $action): RedirectResponse
    {
        $action->handle($request->user(), SettingsData::from($request));

        return redirect('/')->with('success', __('Profile updated.'));
    }
}
