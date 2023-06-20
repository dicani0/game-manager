<?php

namespace App\Http\Controllers\Market;

use App\Actions\Market\OfferRequests\RejectTradeOfferRequest;
use App\Http\Controllers\Controller;
use App\Models\Market\MarketOffer;
use App\Models\Market\OfferRequest;
use App\Processes\Market\AcceptTradeRequestProcess;
use Illuminate\Http\RedirectResponse;

class MarketOfferRequestController extends Controller
{
    public function accept(MarketOffer $offer, OfferRequest $offerRequest, AcceptTradeRequestProcess $process): RedirectResponse
    {
        $process->run($offerRequest);
        return redirect()->back()->with('success', 'Offer accepted!');
    }

    public function reject(MarketOffer $offer, OfferRequest $offerRequest, RejectTradeOfferRequest $process): RedirectResponse
    {
        $process->run($offerRequest);

        return redirect()->back()->with('success', 'Offer rejected!');
    }
}
