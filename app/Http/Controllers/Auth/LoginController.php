<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\LoginUser;
use App\Data\Auth\LoginUserDto;
use App\Exceptions\Auth\EmailNotVerifiedException;
use App\Exceptions\Auth\InvalidCredentialsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LoginController extends Controller
{
    /**
     * @throws InvalidCredentialsException|EmailNotVerifiedException
     */
    public function login(LoginRequest $request, LoginUser $action): RedirectResponse
    {
        $action->handle(LoginUserDto::from($request->validated()));
        return redirect('/')->with('success', 'Logged in successfully.');
    }

    public function loginForm(Request $request): Response
    {
        return Inertia::render('Auth/Login');
    }
}
