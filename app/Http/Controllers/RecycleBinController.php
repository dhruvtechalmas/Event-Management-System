<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Task;
use App\Models\Participant;

class RecycleBinController extends Controller
{
    public function index()
    {
        $events = Event::onlyTrashed()->with(['tasks' => fn($q) => $q->withTrashed(), 'participants' => fn($q) => $q->withTrashed(),])->latest()->get();

        $deletedEventIds = Event::onlyTrashed()->pluck('id');

        $tasks = Task::onlyTrashed()->whereNotIn('event_id', $deletedEventIds)->with('event')->latest()->get();

        $participants = Participant::onlyTrashed()->whereNotIn('event_id', $deletedEventIds)->with('event')->latest()->get();

        return view('backend.recycle-bin', compact('events', 'tasks', 'participants'));
    }
    public function restoreEvent($id)
    {
        $event = Event::onlyTrashed()->with(['tasks' => fn($q) => $q->withTrashed(), 'participants' => fn($q) => $q->withTrashed()])->findOrFail($id);

        $event->restore();

        $event->tasks()->onlyTrashed()->restore();
        
        $event->participants()->onlyTrashed()->restore();

        return back()->with('success', 'Event restored successfully.');
    }

    public function restoreTask($id)
    {
        $task = Task::withTrashed()->findOrFail($id);

        $task->restore();

        return back()->with('success', 'Task restored successfully.');
    }

    public function restoreParticipant($id)
    {
        $participant = Participant::withTrashed()->findOrFail($id);

        $participant->restore();

        return back()->with('success', 'Participant restored successfully.');
    }
    public function forceDeleteEvent($id)
    {
        $event = Event::withTrashed()->findOrFail($id);

        $event->tasks()->withTrashed()->forceDelete();

        $event->participants()->withTrashed()->forceDelete();

        $event->forceDelete();

        return back()->with('success', 'Event permanently deleted.');
    }

    public function forceDeleteTask($id)
    {
        $task = Task::withTrashed()->findOrFail($id);

        $task->forceDelete();

        return back()->with('success', 'Task permanently deleted.');
    }

    public function forceDeleteParticipant($id)
    {
        $participant = Participant::withTrashed()->findOrFail($id);

        $participant->forceDelete();

        return back()->with('success', 'Participant permanently deleted.');
    }
}