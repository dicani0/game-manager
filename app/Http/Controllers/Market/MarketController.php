<?php

namespace App\Http\Controllers\Market;

use App\Data\Market\CancelMarketOfferDto;
use App\Data\Market\CreateMarketOfferDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Market\CancelMarketOfferRequest;
use App\Http\Requests\Market\CreateMarketOfferRequest;
use App\Http\Requests\Market\UserOfferIndexRequest;
use App\Models\Market\MarketOffer;
use App\Models\User;
use App\Processes\Market\CancelMarketOfferProcess;
use App\Processes\Market\CreateMarketOfferProcess;
use App\Queries\Market\MarketOffersWithoutUserQuery;
use App\Queries\Market\UserMarketOffersQuery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MarketController extends Controller
{
    public function index(Request $request, MarketOffersWithoutUserQuery $query): Response
    {
        return Inertia::render('Market/Market', [
            'offers' => $query->handle()->paginate(),
            'sellers' => User::query()->whereNot('id', $request->user()?->getKey())->has('marketOffers')->get(),
        ]);
    }

    public function userOffers(UserOfferIndexRequest $request, UserMarketOffersQuery $query): Response
    {
        return Inertia::render('Market/MyOffers', [
            'offers' => $query->handle()->paginate(),
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
