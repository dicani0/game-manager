<?php

namespace App\Http\Controllers\Guild;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class GuildController extends Controller
{
    public function dashboard(Request $request): Response
    {
        return Inertia::render('Guild/Guild', [
            'guild' => $request->user()?->guild()?->with('users'),
        ]);
    }
}
