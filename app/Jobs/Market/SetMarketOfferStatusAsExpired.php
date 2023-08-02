<?php

namespace App\Jobs\Market;

use App\Actions\Market\CalculateReservedCosmeticAmountAfterOfferCancellation;
use App\Enums\MarketOfferStatusEnum;
use App\Models\Market\MarketOffer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class SetMarketOfferStatusAsExpired implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly MarketOffer $marketOffer)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(CalculateReservedCosmeticAmountAfterOfferCancellation $action): void
    {
        if ($this->marketOffer->status !== MarketOfferStatusEnum::ACTIVE) {
            return;
        }

        DB::transaction(function () use ($action) {
            (new CalculateReservedCosmeticAmountAfterOfferCancellation())->handle($this->marketOffer->user, $this->marketOffer);
            $this->marketOffer->status = MarketOfferStatusEnum::EXPIRED;
            $this->marketOffer->save();
        });
    }
}
