<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Models\User;
use App\Notifications\GeneralNotification;
use App\Services\GoogleCalendarService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;

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
        Event::whereDate('event_date', '<', today())
            ->whereIn('status', ['Ongoing', 'Completed'])
            ->update([
                'status' => 'Completed'
            ]);

        Event::whereDate('event_date', '<', today())
            ->whereIn('status', ['Draft', 'Upcoming'])
            ->update([
                'status' => 'Cancelled'
            ]);

        $query = Event::query();

        if (request()->filled('status')) {
            $query->where('status', request('status'));
        }

        $events = $query->latest()->paginate(25)->withQueryString();

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
    public function store(StoreEventRequest $request)
    {

        $data = $request->validated();

        if ($request->hasFile('event_image')) {
            $data['event_image'] = $request
                ->file('event_image')
                ->store('events', 'public');
        }

        $event = Event::create($data);


        GoogleCalendarService::createEvent($event);

        $users = User::whereHas('tasks', function ($query) use ($event) {
            $query->where('event_id', $event->id);
        })->get();

        foreach ($users as $user) {
            $user->notify(
                new GeneralNotification('event_create', [
                    'event_name' => $event->event_name,
                ])
            );
        }

        if (auth()->id() != $event->user_id) {
            auth()->user()->notify(
                new GeneralNotification('event_created_by_you', [
                    'event_name' => $event->event_name,
                ])
            );
        }

        return redirect()->route('events.index')->with([
            'message' => 'Event Created successful!',
            'alert-type' => 'success'
        ]);
    }

    public function show(Event $event)
    {
        $event->loadCount('participants');
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
    public function update(UpdateEventRequest $request, Event $event)
    {
        $data = $request->validated();

        if ($request->hasFile('event_image')) {

            if ($event->event_image) {
                Storage::disk('public')->delete($event->event_image);
            }

            $data['event_image'] = $request
                ->file('event_image')
                ->store('events', 'public');
        }

        $event->update($data);

        GoogleCalendarService::updateEvent($event);

        $assignedUsers = User::whereHas('tasks', function ($query) use ($event) {
            $query->where('event_id', $event->id);
        })->get();

        foreach ($assignedUsers as $user) {
            $user->notify(
                new GeneralNotification('event_update', [
                    'event_name' => $event->event_name,
                    'event_date' => $event->event_date,
                ])
            );
        }

        if (auth()->id() != $event->user_id) {
            auth()->user()->notify(
                new GeneralNotification('event_update', [
                    'event_name' => $event->event_name,
                    'event_date' => $event->event_date,
                ])
            );
        }

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

        GoogleCalendarService::deleteEvent($event);

        $event->tasks()->delete();

        $event->participants()->delete();

        $event->delete();

        // Redirect to the events list with a success message
        return redirect()->route('events.index')->with([
            'message' => 'Event moved to Recycle Bin successfully!',
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
