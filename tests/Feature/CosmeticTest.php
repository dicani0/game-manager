<?php

namespace Tests\Feature;

use App\Models\Cosmetics\Cosmetic;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CosmeticTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_import(): void
    {
        Artisan::call('app:import-cosmetics-list');
        $this->assertNotEmpty(Cosmetic::all());
    }
}
