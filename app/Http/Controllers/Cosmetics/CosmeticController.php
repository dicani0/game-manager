<?php

namespace App\Http\Controllers\Cosmetics;

use App\Http\Controllers\Controller;
use App\Http\Resources\Cosmetics\CosmeticResource;
use App\Models\Cosmetics\Cosmetic;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CosmeticController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Cosmetics/Cosmetic', [
            'cosmetics' => CosmeticResource::collection(Cosmetic::all())
        ]);
    }
}
