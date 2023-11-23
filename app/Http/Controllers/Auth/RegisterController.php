<?php

namespace App\Http\Controllers\Auth;

use App\Data\Auth\RegisterUserDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Processes\Auth\RegisterProcess;
use Illuminate\Http\RedirectResponse;
use Throwable;

class RegisterController extends Controller
{
    /**
     * @throws Throwable
     */
    public function __invoke(RegisterRequest $request, RegisterProcess $process): RedirectResponse
    {
        $process->run(RegisterUserDto::from($request->validated()));

        return to_route('login')->with(['success' => 'Your account has been created!']);
    }
}
