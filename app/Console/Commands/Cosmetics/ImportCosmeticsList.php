<?php

namespace App\Console\Commands\Cosmetics;

use App\Models\Cosmetics\Cosmetic;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportCosmeticsList extends Command
{
    protected $signature = 'app:import-cosmetics-list';

    public function handle()
    {
        $file = Storage::disk('public')->get('cosmetics.txt');
        $lines = explode("\n", $file);

        foreach ($lines as $line) {
            if (empty($line)) {
                continue;
            }

            Cosmetic::updateOrCreate([
                'name' => str_replace('Token', '', trim($line)),
                'attributes' => null,
                'usable_amount' => 1,
            ]);
        }
    }
}
