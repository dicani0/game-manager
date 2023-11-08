<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Resources\Market\TradeOfferResource;
use App\Queries\Market\UserTradeOffersQuery;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TradeOfferController extends Controller
{
    public function index(Request $request, UserTradeOffersQuery $query): Response
    {
        return Inertia::render('Market/Requests', [
            'requests' => TradeOfferResource::collection($query->handle()->paginate()),
        ]);
    }
}
