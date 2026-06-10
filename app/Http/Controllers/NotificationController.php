<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // 1. Mark a single clicked message as read, then send user to the right page
    public function markAsRead($id)
    {
        // Find the notification belonging to the logged-in user using the ID
        $notification = auth()->user()->notifications()->find($id);
        
        if ($notification) {
            $notification->markAsRead(); // Changes read_at from null to the current time
            
            // Look inside the data to see where to redirect the user
            $type = $notification->data['type'];

            if ($type == 'task') {
                return redirect()->route('tasks.index');
            }
            
            if ($type == 'event_create' || $type == 'event_update' || $type == 'reminder') {
                return redirect()->route('events.index');
            }
        }

        return redirect()->back();
    }

    // 2. Mark absolutely everything unread as read instantly
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }

    // 3. Display the full history list page
    public function history()
    {
        // Fetch all notifications (both read and unread)
        $notifications = auth()->user()->notifications; 
        return view('backend.notifications.history', compact('notifications'));
    }
}
