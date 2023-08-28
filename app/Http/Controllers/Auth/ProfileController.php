<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\Auth\InvalidCredentialsException;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * @throws InvalidCredentialsException
     */
    public function __invoke(): Response
    {
        return Inertia::render('Auth/Profile', [
            'user' => auth()->user()->only('id', 'name', 'email'),
        ]);
    }
}
