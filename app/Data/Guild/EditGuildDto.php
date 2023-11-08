<?php

namespace App\Data\Guild;

use App\Models\Guild\Guild;
use App\Rules\Attributes\CharacterIsInGuild;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Spatie\LaravelData\Attributes\FromRouteParameter;
use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\File;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Sometimes;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Support\Validation\References\RouteParameterReference;

class EditGuildDto extends Data
{
    public function __construct(
        #[Unique('guilds', 'name', ignore: new RouteParameterReference('guild', 'id')), StringType, Min(3), Max(25)]
        public string                $name,
        #[File, Sometimes]
        public Optional|UploadedFile $logo,
        #[StringType, Max(255), Sometimes, Nullable]
        public Optional|string|null  $description,
        #[FromRouteParameter('guild')]
        public Guild                 $guild,
        #[Required, IntegerType, CharacterIsInGuild]
        public int $leader_id,
        #[BooleanType]
        public bool                  $recruiting = false,
    )
    {
    }

    public static function authorize(): bool
    {
        return Gate::allows('update', [Guild::class, request()->route('guild')]);
    }
}