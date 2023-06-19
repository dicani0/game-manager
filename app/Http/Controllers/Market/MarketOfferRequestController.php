<?php

namespace App\Http\Controllers\Market;

use App\Data\Market\CancelMarketOfferDto;
use App\Data\Market\CreateMarketOfferDto;
use App\Data\Market\CreateMarketOfferRequestDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Market\CancelMarketOfferRequest;
use App\Http\Requests\Market\CreateBuyOfferRequest;
use App\Http\Requests\Market\CreateMarketOfferRequest;
use App\Http\Requests\Market\UserOfferIndexRequest;
use App\Models\Market\MarketOffer;
use App\Models\Market\OfferRequest;
use App\Models\User;
use App\Processes\Market\CancelMarketOfferProcess;
use App\Processes\Market\CreateBuyOfferRequestProcess;
use App\Processes\Market\CreateMarketOfferProcess;
use App\Queries\Market\MarketOffersWithoutUserQuery;
use App\Queries\Market\UserMarketOffersQuery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MarketOfferRequestController extends Controller
{
    public function accept(MarketOffer $offer, OfferRequest $offerRequest): RedirectResponse
    {
        return redirect()->back()->with('success', 'Offer accepted!');
    }

    public function decline(MarketOffer $offer, OfferRequest $offerRequest): RedirectResponse
    {
        return redirect()->back()->with('success', 'Offer declined!');
    }
}
