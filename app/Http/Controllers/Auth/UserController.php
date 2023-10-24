<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Auth\PublicUserResource;
use App\Queries\Auth\PublicUsersQuery;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function getPublicUsers(Request $request, PublicUsersQuery $query): Response
    {
        return Inertia::render('Auth/UsersList', [
            'users' => PublicUserResource::collection($query->handle()->paginate(30)),
        ]);
    }
}
