<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{

    public function index(Request $request)
    {
        $notifications = Auth::user()->unreadNotifications;
        Auth::user()->unreadNotifications->markAsRead();
        return view('home.notifications.notification-list', ['notifications' => $notifications]);
    }
}
