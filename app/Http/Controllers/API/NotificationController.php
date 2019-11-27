<?php

namespace App\Http\Controllers\API;

use App\Auth;

class NotificationController
{
    public function get()
    {
        $user = Auth::user();
        $notifications = $user->notifications;

        if (!is_array($notifications)) {
            $notifications = array_values($notifications->toArray());
        }

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
