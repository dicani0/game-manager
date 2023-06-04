<?php

namespace App\Http\Controllers\Market;

use App\Data\Market\CreateMarketOfferDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Market\CreateMarketOfferRequest;
use App\Models\Market\MarketOffer;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class MarketController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Market/Market', [
            'offers' => MarketOffer::with(['items.cosmetic', 'user'])->get(),
        ]);
    }

    public function store(CreateMarketOfferRequest $request): RedirectResponse
    {
        $dto = CreateMarketOfferDto::from($request);
        $offer = MarketOffer::create([
            'user_id' => $request->user()->getKey(),
            'type' => $dto->type,
            'expires_at' => now()->addDays(14)->startOfDay(),
        ]);
        $offer->items()->createMany($dto->items->toArray());

        return redirect()->back()->with('success', 'Offer created!');
    }
}
