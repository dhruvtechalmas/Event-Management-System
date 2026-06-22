<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreParticipantRequest;
use App\Http\Requests\UpdateParticipantRequest;
use App\Models\Event;
use App\Models\Participant;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventInvitationMail;
use App\Mail\ParticipantRegistrationMail;

class ParticipantController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:participant.index', only: ['index']),
            new Middleware('permission:participant.create', only: ['create', 'store']),
            new Middleware('permission:participant.edit', only: ['edit', 'update']),
            new Middleware('permission:participant.delete', only: ['destroy']),
            new Middleware('permission:participant.view', only: ['show']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->hasRole('SuperAdmin')) {
            $participants = Participant::with('event')->latest()->paginate(10);
        } else {
            $eventIds = Task::where('assigned_to', auth()->id())->pluck('event_id');

            $participants = Participant::with('event')->whereIn('event_id', $eventIds)->latest()->paginate(10);
        }

        $events = Event::all();

        return view('backend.participants.list', compact('participants', 'events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $events = Event::all();
        return view('backend.participants.create', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreParticipantRequest $request)
    {

        $participant = Participant::create($request->validated());

        $event = Event::findOrFail($participant->event_id);

        Mail::to($participant->email)
            ->send(new EventInvitationMail($event, $participant));

        Mail::to($participant->email)
            ->send(new ParticipantRegistrationMail($participant, $event));

        // dd($participant->email);


        return redirect()->route('participants.index')->with([
            'message' => 'Participant Created successful!',
            'alert-type' => 'success'
        ]);
    }


    public function show(Participant $participant)
    {
        return view('backend.participants.view', compact('participant'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Participant $participant)
    {
        $participant = Participant::findOrFail($participant->id);
        $event = Event::all();
        return view('backend.participants.edit', compact('participant', 'event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateParticipantRequest $request, Participant $participant)
    {

        $participant = Participant::findOrFail($participant->id);

        $participant->update($request->validated());

        return redirect()->route('participants.index')->with([
            'message' => 'Participant Updated successful!',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Participant $participant)
    {
        $participant->delete();

        return redirect()->route('participants.index')->with([
            'message' => 'Participant moved to Recycle Bin successfully!',
            'alert-type' => 'success'
        ]);
    }


    public function eventRegister(StoreParticipantRequest $request)
    {
        $participant = Participant::create($request->validated());

        $event = Event::findOrFail($participant->event_id);

        Mail::to($participant->email)
            ->send(new EventInvitationMail($event, $participant));

        Mail::to($participant->email)
            ->send(new ParticipantRegistrationMail($participant, $event));

        return redirect('/')
            ->with('success', 'You are registered for the event successfully!');

    }

}
