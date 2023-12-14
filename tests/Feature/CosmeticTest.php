<?php

namespace Tests\Feature;

use App\Models\Items\Item;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CosmeticTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_import(): void
    {
        Artisan::call('import-items');
        $this->assertNotEmpty(Item::all());
    }
}
