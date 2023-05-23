<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\Auth\InvalidCredentialsException;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class ProfileController extends Controller
{
    /**
     * @throws InvalidCredentialsException
     */
    public function __invoke()
    {
        return Inertia::render('Auth/Profile', [
            'user' => auth()->user()->only('id', 'name', 'email'),
        ]);
    }
}
