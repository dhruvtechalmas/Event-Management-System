<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {

        $totalEvents = Event::count();

        $upcomingEvents = Event::whereDate(
            'event_date',
            '>=',
            now()
        )->count();

        $totalParticipants = Participant::count();

        $totalTasks = Task::count();

        $completedTasks = Task::where('status', 'completed')->count();


        $recentEvents = Event::latest()
            ->take(5)
            ->get();

        $upcomingEventList = Event::whereDate(
            'event_date',
            '>=',
            now()
        )->orderBy( 'event_date')
            ->take(5)
            ->get();

        $pendingTasks = Task::where(
            'status',
            'pending'
        )->latest()
            ->take(5)
            ->get();

        $notifications = Auth::user()
            ->notifications()
            ->latest()
            ->take(5)
            ->get();

        return view(
            'backend.index',
            compact(
                'totalEvents',
                'upcomingEvents',
                'totalParticipants',
                'totalTasks',
                'completedTasks',
                'recentEvents',
                'upcomingEventList',
                'pendingTasks',
                'notifications'
            )
        );

    }
}
