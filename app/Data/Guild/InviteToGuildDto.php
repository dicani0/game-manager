<?php

namespace App\Data\Guild;

use App\Models\Character\Character;
use App\Models\Guild\Guild;
use Illuminate\Support\Facades\Gate;
use Spatie\LaravelData\Attributes\FromRouteParameter;
use Spatie\LaravelData\Data;

class InviteToGuildDto extends Data
{
    public function __construct(
        #[FromRouteParameter('guild')]
        public Guild     $guild,
        #[FromRouteParameter('character')]
        public Character $character,
    )
    {
    }

    public static function authorize(): bool
    {
        return Gate::allows('invite', [request()->route('guild'), request()->route('character')]);
    }
}