<?php

namespace App\Data\Poll;

use App\Casts\CarbonCast;
use App\Enums\PollStatusEnum;
use App\Models\Poll\Poll;
use App\Rules\Poll\CorrectPollableClass;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\FromRouteParameter;
use Spatie\LaravelData\Attributes\Validation\After;
use Spatie\LaravelData\Attributes\Validation\AfterOrEqual;
use Spatie\LaravelData\Attributes\Validation\Before;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\RequiredWith;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Optional;

final class UpdatePollDto extends BasePollDto
{
    public function __construct(
        #[Required, StringType, Max(255)]
        public string               $title,

        #[Nullable, StringType, Max(1000)]
        public string|Optional|null $description,

        #[WithCast(CarbonCast::class)]
        #[Required, Date, Before('end_date'), AfterOrEqual('now')]
        public DateTime             $start_date,

        #[WithCast(CarbonCast::class)]
        #[Required, Date, After('start_date')]
        public DateTime             $end_date,

        #[Rule(new CorrectPollableClass()), RequiredWith('pollable_id')]
        public string|Optional|null $pollable_type,

        #[RequiredWith('pollable_type')]
        public int|Optional|null    $pollable_id,

        #[DataCollectionOf(UpdateQuestionDto::class)]
        #[Min(1), Required]
        public DataCollection       $questions,

        #[FromRouteParameter('poll'), Required]
        public Poll                 $poll,

        public PollStatusEnum       $status = PollStatusEnum::DRAFT,

    )
    {
        parent::__construct(
            $this->title,
            $this->description,
            $this->start_date,
            $this->end_date,
            $this->pollable_type,
            $this->pollable_id,
            $this->questions,
        );
    }

    public static function authorize(): bool
    {
        return Auth::user()?->can('update', request()->route('poll'));
    }
}