<?php

namespace App\Http\Controllers\Market;

use App\Actions\Market\TradeOffers\RejectTradeOffer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Market\Offer\AcceptRejectTradeRequest;
use App\Models\Market\TradeOffer;
use App\Processes\Market\AcceptTradeRequestProcess;
use Illuminate\Http\RedirectResponse;
use Throwable;

class MarketOfferRequestController extends Controller
{
    /**
     * @throws Throwable
     */
    public function accept(AcceptRejectTradeRequest $request, TradeOffer $offerRequest, AcceptTradeRequestProcess $process): RedirectResponse
    {
        $process->run($offerRequest);
        return redirect()->back()->with('success', 'Offer accepted!');
    }

    public function reject(AcceptRejectTradeRequest $request, TradeOffer $offerRequest, RejectTradeOffer $action): RedirectResponse
    {
        $action->handle($offerRequest);

        return redirect()->back()->with('success', 'Offer rejected!');
    }
}
