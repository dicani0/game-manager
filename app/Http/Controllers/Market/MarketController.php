<?php

namespace App\Http\Controllers\Market;

use App\Data\Market\CancelMarketOfferDto;
use App\Data\Market\CreateMarketOfferDto;
use App\Enums\MarketOfferStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Market\CancelMarketOfferRequest;
use App\Http\Requests\Market\CreateMarketOfferRequest;
use App\Models\Market\MarketOffer;
use App\Models\User;
use App\Processes\Market\CancelMarketOfferProcess;
use App\Processes\Market\CreateMarketOfferProcess;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class MarketController extends Controller
{
    public function index(Request $request): Response
    {
        $offers = QueryBuilder::for(MarketOffer::class)
            ->orderBy('promoted', 'desc')
            ->whereNot('user_id', auth()->id())
            ->where('status', MarketOfferStatusEnum::ACTIVE->value)
            ->with(['items.cosmetic', 'user'])
            ->allowedFilters([
                AllowedFilter::exact('seller', 'user_id'),
                AllowedFilter::callback('item', fn ($query, $value) => $query->whereHas('items', fn ($query) => $query->whereHas('cosmetic', fn($query) => $query->where('name', 'like', "%{$value}%")))),
            ])
            ->allowedSorts(['promoted', 'created_at'])
            ->paginate();

        return Inertia::render('Market/Market', [
            'offers' => $offers,
            'sellers' => User::has('marketOffers')->get(),
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
