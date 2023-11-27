<?php

namespace App\Http\Controllers\Notifications;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function notifications(): Response
    {
        return Inertia::render('Notifications/Notifications', [
            'notifications' => Auth::user()->notifications()->paginate(3),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function readNotification()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }
}
