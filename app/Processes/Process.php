<?php

namespace App\Processes;

use Illuminate\Support\Facades\Pipeline;

abstract class Process
{
    protected array $tasks = [];

    public function run(object $payload): mixed
    {
        return Pipeline::send(
            passable: $payload
        )->through(
            pipes: $this->tasks
        )->thenReturn();
    }
}
