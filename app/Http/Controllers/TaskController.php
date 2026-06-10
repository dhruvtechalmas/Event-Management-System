<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Event;
use App\Models\User;

use App\Notifications\GeneralNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with(['event', 'assignee'])->latest()->paginate(10);
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
            'due_date' => 'required|date|max:20',
            'status' => 'required|in:pending,in_progress,completed',
            'comment' => 'nullable|string',
        ]);

        // After saving your task...
        $task = Task::create($validatedTask);

        if ($task->assigned_to) {
            $assignedUser = User::find($task->assigned_to);

            $title = "New Task Assigned 📋";
            $message = "You have been assigned the task: " . $task->title;
            $type = "task";

            // Send the postcard to the assigned user
            $assignedUser->notify(new  GeneralNotification($title, $message, $type));
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
}
