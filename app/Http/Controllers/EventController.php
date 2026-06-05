<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::latest()->paginate(5);
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
        $validatedEvent = $request->validate([
            'event_name' => 'required|string|max:255',
            'event_type' => 'nullable|string|max:255',
            'event_date' => 'required|date',
            'event_time' => 'nullable|date_format:H:i:s',
            'event_location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Draft,Upcoming,Ongoing,Completed,Cancelled',
        ]);

        Event::create($validatedEvent);

        return redirect()->route('events.index')->with([
            'message' => 'Event Created successful!',
            'alert-type' => 'success'
        ]);

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
            'event_time' => 'nullable|date_format:H:i:s',
            'event_location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Draft,Upcoming,Ongoing,Completed,Cancelled',
        ]);

              // Find the user and update their information
        $event->update($validatedEvent);

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
}
