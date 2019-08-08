<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController
{
    public function get(Request $request)
    {
        $notifications = Auth::user()->notifications;

        return response()->json(
            $notifications,
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE);
    }

    public function markAsSeen($id)
    {
        $user = Auth::user();
        $notification = $user->unreadNotifications->where('id', '=', $id);

        if ($notification != null) {
            $notification->markAsRead();
        }
    }
}
