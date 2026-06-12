<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Event;
use App\Models\User;
use App\Notifications\GeneralNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class TaskController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:task.index', only: ['index']),
            new Middleware('permission:task.create', only: ['create', 'store']),
            new Middleware('permission:task.edit', only: ['edit', 'update']),
            new Middleware('permission:task.delete', only: ['destroy']),
            new Middleware('permission:task.view', only: ['show']),
            new Middleware('permission:task.assign', only: ['assigntask']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->hasRole('SuperAdmin')) {
            $tasks = Task::with(['event', 'assignee'])->latest()->paginate(10);
        } else {
            $tasks = Task::with(['event', 'assignee'])->where('assigned_to', auth()->id())->latest()->paginate(10);
        }

        $events = Event::all();

        $users = User::withoutRole('SuperAdmin')->where('id', '!=', Auth::id())->get();

        return view('backend.tasks.list', compact('tasks', 'events', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $events = Event::all();
        $users = User::withoutRole('SuperAdmin')->where('id', '!=', Auth::id())->get();
        return view('backend.tasks.create', compact('events', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedTask = $request->validate([
            'title' => 'required|string|max:255',
            'event_id' => 'required|exists:events,id',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'required|date|max:10',
            'status' => 'required|in:pending,in_progress,completed',
            'comment' => 'nullable|string',
        ]);

        $task = Task::create($validatedTask);

        $assignedUser = User::find($task->assigned_to);

        if ($assignedUser) {
            $title = "New Task Assigned 📋";
            $message = "You have been assigned the task: " . $task->title;
            $type = "task";

            $assignedUser->notify(new GeneralNotification($title, $message, $type));

            if (auth()->id() != $task->user_id) {
                auth()->user()->notify(
                    new GeneralNotification(
                        "Task Created Successfully ✔️",
                        "You successfully Task: " . $task->title,
                        'task'
                    )
                );
            }

        }

        return redirect()->route('tasks.index')->with([
            'message' => 'Task Created successful!',
            'alert-type' => 'success'
        ]);
    }


    public function assigntask(Request $request, Task $task)
    {
        $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $task->update([
            'assigned_to' => $request->assigned_to,
        ]);

        return redirect()->route('tasks.index')->with([
            'message' => 'Task Assigned Successfully!',
            'alert-type' => 'success'
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $task = Task::findOrFail($task->id);
        $event = Event::all();
        $user = User::withoutRole('SuperAdmin')->where('id', '!=', Auth::id())->get();
        return view('backend.tasks.edit', compact('event', 'user', 'task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $task = Task::findOrFail($task->id);

        $validatedTask = $request->validate([
            'title' => 'required|string|max:255',
            'event_id' => 'required|exists:events,id',
            'assigned_to' => 'exists:users,id',
            'due_date' => 'required|date|max:20',
            'status' => 'required|in:pending,in_progress,completed',
            'comment' => 'nullable|string',
        ]);

        $task->update($validatedTask);

        return redirect()->route('tasks.index')->with([
            'message' => 'Task Created successful!',
            'alert-type' => 'success'
        ]);
    }

    public function show(Task $task)
    {
        return view('backend.tasks.view', compact('task'));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with([
            'message' => 'Task Deleted successful!',
            'alert-type' => 'success'
        ]);
    }

    public function viewDetails($id)
    {
        $task = Task::with(['event', 'assignee'])->findOrFail($id);

        return response()->json([
            'task' => [
                'id' => $task->id,
                'title' => $task->title,
                'status' => $task->status,
                'description' => $task->comment,
                'due_date' => $task->due_date,
                'created_at' => $task->created_at->format('d M Y'),
            ],

            'event' => $task->event ? [
                'event_name' => $task->event->event_name,
                'event_type' => $task->event->event_type,
                'event_date' => $task->event->event_date,
                'event_time' => $task->event->event_time,
                'event_location' => $task->event->event_location,
                'description' => $task->event->description,
            ] : null,

            'assignee' => $task->assignee ? [
                'name' => $task->assignee->name,
                'email' => $task->assignee->email,
                'phone' => $task->assignee->phone,
            ] : null,
        ]);
    }

}
