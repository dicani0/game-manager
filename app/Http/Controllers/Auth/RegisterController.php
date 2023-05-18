<?php

namespace App\Http\Controllers\Auth;

use App\Data\RegisterUserDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Processes\Auth\RegisterProcess;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request, RegisterProcess $process)
    {
        $process->run(RegisterUserDto::from($request->validated()));

        return to_route('login')->with(['success' => 'Your account has been created!']);
    }
}
