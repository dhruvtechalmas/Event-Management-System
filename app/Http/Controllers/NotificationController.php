<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();

            $type = $notification->data['type'] ?? '';

            if ($type == 'task') {
                return redirect()->route('tasks.index');
            }

            if (in_array($type, ['event_create', 'event_update', 'reminder'])) {
                return redirect()->route('events.index');
            }
        }

        return redirect()->back();
    }

    public function markAllAsRead()
    {
        auth()->user()
            ->unreadNotifications
            ->markAsRead();

        return response()->json([
            'success' => true
        ]);
    }

    public function history()
    {
        $notifications = auth()->user()->notifications;
        return view('backend.notifications.history', compact('notifications'));
    }

    public function latest()
    {
        $notifications = auth()->user()
            ->unreadNotifications
            ->take(10)
            ->map(function ($notification) {


                return [
                    'id' => $notification->id,
                    'title' => $notification->data['title'] ?? '',
                    'message' => $notification->data['message'] ?? '',
                    'time' => $notification->created_at->diffForHumans(),
                    'url' => $notification->data['action_url'] ?? '#',
                ];
            });

        return response()->json([
            'count' => auth()->user()->unreadNotifications()->count(),
            'notifications' => $notifications->values(),
        ]);

    }

}
