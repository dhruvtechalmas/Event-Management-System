<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\Event;
use App\Models\User;
use App\Mail\TaskAssignmentMail;
use App\Notifications\GeneralNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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

        $query = Task::with(['event', 'assignee']);

        if (!auth()->user()->hasRole('SuperAdmin')) {
            $query->where('assigned_to', auth()->id());
        }

        if (request()->filled('status')) {
            $query->where('status', request('status'));
        }

        if (request()->filled('event_id')) {
            $query->where('event_id', request()->event_id);
        }

        $tasks = $query->latest()->paginate(10)->withQueryString();

        if (auth()->user()->hasRole('SuperAdmin')) {
            $events = Event::all();
        } else {
            $assignedEventIds = Task::where('assigned_to', auth()->id())->pluck('event_id');
            $events = Event::whereIn('id', $assignedEventIds)->get();
        }

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
    public function store(StoreTaskRequest $request)
    {
        $task = Task::create($request->validated());

        $event = Event::findOrFail($request->event_id);
        if ($request->due_date > $event->event_date) {
            return back()->withInput()->withErrors([
                'due_date' => 'Due Date cannot be after Event Date.'
            ]);
        }

        $task->load('event');

        $assignedUser = User::find($task->assigned_to);

        if ($assignedUser) {
            $assignedUser->notify(
                new GeneralNotification(
                    'task_create',
                    [
                        'task_title' => $task->title,
                    ]
                )
            );

            if ($assignedUser->email) {
                $creator = auth()->user() ?? null;
                Mail::to($assignedUser->email)
                    ->send(new TaskAssignmentMail($task, $task->event, $assignedUser, $creator));
            }

            // dd($assignedUser->email);
            auth()->user()->notify(
                new GeneralNotification(
                    'task_created_by_you',
                    [
                        'task_title' => $task->title,
                    ]
                )
            );

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
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task = Task::findOrFail($task->id);

        $task->update($request->validated());

        return redirect()->route('tasks.index')->with([
            'message' => 'Task Created successful!',
            'alert-type' => 'success'
        ]);
    }

    public function show(Task $task)
    {
        if (
            !auth()->user()->hasRole('SuperAdmin') &&
            $task->assigned_to != auth()->id()
        ) {
            abort(403, 'Unauthorized access.');
        }

        return view('backend.tasks.view', compact('task'));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with([
            'message' => 'Task moved to Recycle Bin successfully!',
            'alert-type' => 'success'
        ]);
    }

    public function viewDetails(string $id)
    {
        $task = Task::with(['event', 'assignee'])->findOrFail($id);

        if (
            !auth()->user()->hasRole('SuperAdmin') &&
            $task->assigned_to != auth()->id()
        ) {
            return redirect()->route('tasks.index')->with([
                'message' => 'You are not authorized to view this task.',
                'alert-type' => 'error',
            ]);
        }

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
