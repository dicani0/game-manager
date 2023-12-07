<?php

namespace App\Models\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Pollable
{
    public function polls(): MorphMany;
}