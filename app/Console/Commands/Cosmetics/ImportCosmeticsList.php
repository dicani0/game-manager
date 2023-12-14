<?php

namespace App\Console\Commands\Cosmetics;

use App\Models\Items\Item;
use File;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Isolatable;
use Illuminate\Support\Str;
use Throwable;

class ImportCosmeticsList extends Command implements Isolatable
{
    protected $signature = 'import-items';

    protected $description = 'Import items from json file';

    public function handle(): void
    {
        $path = resource_path().'/items.json';

        try {
            $file = File::get($path);
        } catch (Throwable $th) {
            $this->error('File not found');

            return;
        }

        $this->info("\n File found");

        $items = collect(json_decode($file, true))->map(fn (string $item) => Str::title($item));

        $this->withProgressBar($items, function (string $item) {
            $this->info("\n Importing {$item}");

            Item::updateOrCreate([
                'name' => $item,
                'attributes' => null,
                'usable_amount' => 1,
            ]);

            $this->info("\n Imported {$item}");
        });
        $this->info("\n Items imported");
    }
}
