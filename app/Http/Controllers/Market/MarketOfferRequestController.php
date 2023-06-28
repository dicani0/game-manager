<?php

namespace App\Http\Controllers\Market;

use App\Actions\Market\TradeOffers\RejectTradeOffer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Market\Offer\AcceptRejectTradeRequest;
use App\Models\Market\MarketOffer;
use App\Models\Market\TradeOffer;
use App\Processes\Market\AcceptTradeRequestProcess;
use Illuminate\Http\RedirectResponse;

class MarketOfferRequestController extends Controller
{
    public function accept(AcceptRejectTradeRequest $request, MarketOffer $offer, TradeOffer $offerRequest, AcceptTradeRequestProcess $process): RedirectResponse
    {
        $process->run($offerRequest);
        return redirect()->back()->with('success', 'Offer accepted!');
    }

    public function reject(AcceptRejectTradeRequest $request, MarketOffer $offer, TradeOffer $offerRequest, RejectTradeOffer $action): RedirectResponse
    {
        $action->handle($offerRequest);

        return redirect()->back()->with('success', 'Offer rejected!');
    }
}
