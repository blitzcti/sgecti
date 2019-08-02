<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Auth;

class NotificationController
{
    public function markAsSeen($id)
    {
        $user = Auth::user();
        $notification = $user->unreadNotifications->where('id', '=', $id);

        if ($notification != null) {
            $notification->markAsRead();
        }
    }
}
