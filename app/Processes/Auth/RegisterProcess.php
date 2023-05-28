<?php

namespace App\Processes\Auth;

use App\Actions\Auth\AssignUserRole;
use App\Actions\Auth\RegisterUser;
use App\Processes\Process;

class RegisterProcess extends Process
{
    protected array $tasks = [
        RegisterUser::class,
        AssignUserRole::class,
    ];
}
