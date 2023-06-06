<?php

namespace App\Http\Controllers\Market;

use App\Data\Market\CancelMarketOfferDto;
use App\Data\Market\CreateMarketOfferDto;
use App\Enums\MarketOfferStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Market\CancelMarketOfferRequest;
use App\Http\Requests\Market\CreateMarketOfferRequest;
use App\Models\Market\MarketOffer;
use App\Processes\Market\CancelMarketOfferProcess;
use App\Processes\Market\CreateMarketOfferProcess;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class MarketController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Market/Market', [
            'offers' => MarketOffer::with(['items.cosmetic', 'user'])->whereStatus(MarketOfferStatusEnum::ACTIVE->value)->orderBy('promoted', 'desc')->orderBy('created_at', 'desc')->get(),
        ]);
    }

    public function store(CreateMarketOfferRequest $request, CreateMarketOfferProcess $process): RedirectResponse
    {
        $dto = CreateMarketOfferDto::from($request);
        $dto->user = $request->user();

        $process->run($dto);

        return redirect()->back()->with('success', 'Offer created!');
    }

    public function cancel(CancelMarketOfferRequest $request, MarketOffer $offer, CancelMarketOfferProcess $process): RedirectResponse
    {
        $dto = new CancelMarketOfferDto(
            user: $request->user(),
            offer: $offer,
        );

        $process->run($dto);

        return redirect()->back()->with('success', 'Offer canceled!');
    }
}
