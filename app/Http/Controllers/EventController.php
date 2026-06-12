<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Notifications\GeneralNotification;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class EventController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:event.index', only: ['index']),
            new Middleware('permission:event.create', only: ['create', 'store']),
            new Middleware('permission:event.edit', only: ['edit', 'update']),
            new Middleware('permission:event.delete', only: ['destroy']),
            new Middleware('permission:event.view', only: ['show']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::latest()->paginate(25);
        return view('backend.events.list', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $event = new Event();
        return view('backend.events.create', compact('event'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validatedEvent = $request->validate([
            'event_name' => 'required|string|max:255',
            'event_type' => 'nullable|string|max:255',
            'event_date' => 'required|date',
            'event_time' => 'nullable|date_format:H:i',
            'event_location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Draft,Upcoming,Ongoing,Completed,Cancelled',
        ]);

        if (!empty($validatedEvent['event_time'])) {
            $validatedEvent['event_time'] .= ':00';
        }

        $event = Event::create($validatedEvent);

        $users = User::whereHas('tasks', function ($query) use ($event) {
            $query->where('event_id', $event->id);
        })->get();

        foreach ($users as $user)
            $user->notify(new GeneralNotification(
                "New Event Assigned 🎉",
                "You have been assigned to: " . $event->event_name,
                'event_create'
            ));

        // 2. Notify the creator (jo bana rha hein usko) if he is not the assignee
        if (auth()->id() != $event->user_id)
            auth()->user()->notify(new GeneralNotification(
                "Event Created Successfully ✔️",
                "You successfully created: " . $event->event_name,
                'event_create'
            ));

        return redirect()->route('events.index')->with([
            'message' => 'Event Created successful!',
            'alert-type' => 'success'
        ]);

    }

    public function show(Event $event)
    {
        return view('backend.events.view', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $event = Event::findOrFail($event->id);

        return view('backend.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $event = Event::findOrFail($event->id);

        $validatedEvent = $request->validate([
            'event_name' => 'required|string|max:255',
            'event_type' => 'nullable|string|max:255',
            'event_date' => 'required|date',
            'event_time' => 'nullable',
            'date_format:H:i,H:i:s',
            'event_location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Draft,Upcoming,Ongoing,Completed,Cancelled',
        ]);


        if (!empty($validatedEvent['event_time'])) {
            if (substr_count($validatedEvent['event_time'], ':') == 1) {
                $validatedEvent['event_time'] .= ':00';
            }
        }

        $event->update($validatedEvent);

        $assignedUsers = User::whereHas('tasks', function ($query) use ($event) {

            $query->where('event_id', $event->id);

        })->get();

        foreach ($assignedUsers as $user) {
            $title = "Event Updated: " . $event->event_name . " 🔄";
            $message = "The schedule has been updated to " . $event->event_date;
            $type = "event_create";

            $user->notify(new GeneralNotification($title, $message, $type));
        }

        //jo user ne update kiya hein usko notification jayegi
        if (auth()->id() != $event->user_id)
            auth()->user()->notify(new GeneralNotification(
                "Event Updated Successfully ✔️",
                "You successfully Updated: " . $event->event_name,
                'event_update'
            ));

        return redirect()->route('events.index')->with([
            'message' => 'Event Updated successful!',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        // Redirect to the events list with a success message
        return redirect()->route('events.index')->with([
            'message' => 'Event Deleted successful!',
            'alert-type' => 'success'
        ]);
    }

    // Render the calendar backend view
    public function calendarindex()
    {
        return view('backend.calendar');
    }

    // Return structured event streams for FullCalendar
    public function getEvents()
    {
        // dd(Event::all());
        $events = Event::all()->map(function ($event) {

            $color = match ($event->status) {
                'Draft' => '#6c757d',
                'Upcoming' => '#0d6efd',
                'Ongoing' => '#198754',
                'Completed' => '#0dcaf0',
                'Cancelled' => '#dc3545',
                default => '#0d6efd'
            };

            return [
                'id' => $event->id,
                'title' => $event->event_name,
                'start' => $event->event_date . ($event->event_time ? 'T' . $event->event_time : ''),
                'url' => route('events.show', $event->id),

                'backgroundColor' => $color,
                'borderColor' => $color,
                'textColor' => '#100707',

                'extendedProps' => [
                    'description' => $event->description,
                    'type' => $event->event_type,
                    'location' => $event->event_location,
                    'status' => $event->status,
                ]
            ];
        });

        return response()->json($events);
    }
}
