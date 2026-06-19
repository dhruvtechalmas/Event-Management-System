<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Task;
use App\Models\Participant;

class RecycleBinController extends Controller
{
    public function index()
    {
        $events = Event::onlyTrashed()
            ->with([
                'tasks' => function ($query) {
                    $query->withTrashed();
                },
                'participants' => function ($query) {
                    $query->withTrashed();
                },
            ])
            ->latest()
            ->get();

        $tasks = Task::onlyTrashed()
            ->with('event')
            ->latest()
            ->get();

        $participants = Participant::onlyTrashed()
            ->with('event')
            ->latest()
            ->get();

        return view(
            'backend.recycle-bin',
            compact(
                'events',
                'tasks',
                'participants'
            )
        );
    }
    
    public function restoreEvent($id)
    {
        $event = Event::withTrashed()
            ->findOrFail($id);

        $event->restore();

        $event->tasks()
            ->withTrashed()
            ->restore();

        $event->participants()
            ->withTrashed()
            ->restore();

        return back()
            ->with(
                'success',
                'Event restored successfully.'
            );
    }

    public function restoreTask($id)
    {
        $task = Task::withTrashed()
            ->findOrFail($id);

        $task->restore();

        return back()->with(
            'success',
            'Task restored successfully.'
        );
    }

    public function restoreParticipant($id)
    {
        $participant = Participant::withTrashed()
            ->findOrFail($id);

        $participant->restore();

        return back()->with(
            'success',
            'Participant restored successfully.'
        );
    }
    public function forceDeleteEvent($id)
    {
        $event = Event::withTrashed()
            ->findOrFail($id);

        $event->tasks()
            ->withTrashed()
            ->forceDelete();

        $event->participants()
            ->withTrashed()
            ->forceDelete();

        $event->forceDelete();

        return back()
            ->with(
                'success',
                'Event permanently deleted.'
            );
    }

    public function forceDeleteTask($id)
    {
        $task = Task::withTrashed()
            ->findOrFail($id);

        $task->forceDelete();

        return back()->with(
            'success',
            'Task permanently deleted.'
        );
    }

    public function forceDeleteParticipant($id)
    {
        $participant = Participant::withTrashed()
            ->findOrFail($id);

        $participant->forceDelete();

        return back()->with(
            'success',
            'Participant permanently deleted.'
        );
    }
}