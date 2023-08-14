<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\Auth\InvalidCredentialsException;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    /**
     * @throws InvalidCredentialsException
     */
    public function __invoke(Request $request): RedirectResponse
    {
        Auth::logout();

        return redirect('/auth/login')->with('success', 'Logged out!');
    }
}
