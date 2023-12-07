<?php

namespace App\Http\Controllers\Notifications;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Notifications\DatabaseNotification;
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
            'all_notifications' => NotificationResource::collection(Auth::user()->notifications()->paginate(50)),
        ]);
    }

    public function readAll(): RedirectResponse
    {
        /* @phpstan-ignore-next-line */
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function readNotification(DatabaseNotification $notification): RedirectResponse
    {
        $this->authorize('read', $notification);

        $notification->markAsRead();
        return array_key_exists('link', $notification->data) ?
            redirect($notification->data['link']) : redirect()->back();
    }
}
