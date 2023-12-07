<?php

namespace App\Data\Guild;

use App\Models\Guild\Guild;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\File;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Sometimes;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class CreateGuildDto extends Data
{
    public function __construct(
        #[Required, Unique('guilds', 'name'), StringType, Min(3), Max(25)]
        public string $name,
        #[Required, Exists('characters', 'id')]
        public int $leader_id,
        #[File, Sometimes]
        public Optional|UploadedFile $logo,
        #[StringType, Max(255), Sometimes]
        public Optional|string $description,
        public bool $recruiting = false,
        public ?Guild $guild = null,
    ) {
    }

    public static function authorize(): bool
    {
        return Gate::allows('store', Guild::class);
    }
}
