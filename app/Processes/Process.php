<?php

namespace App\Processes;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Pipeline;
use Throwable;

abstract class Process
{
    protected array $tasks = [];

    /**
     * @throws Throwable
     */
    public function run(object $payload): mixed
    {
        return DB::transaction(function () use ($payload) {
            return Pipeline::send(passable: $payload)
                ->through(pipes: $this->tasks)
                ->thenReturn();
        });
    }

}
