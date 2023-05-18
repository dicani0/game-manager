<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\LoginUser;
use App\Data\LoginUserDto;
use App\Exceptions\Auth\InvalidCredentialsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class LoginController extends Controller
{
    /**
     * @throws InvalidCredentialsException
     */
    public function __invoke(LoginRequest $request, LoginUser $action)
    {
        $action->handle(LoginUserDto::from($request->validated()));
        return redirect('/')->with('success', 'Logged in successfully.');
    }
}
