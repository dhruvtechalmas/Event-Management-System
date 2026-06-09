<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $participants = Participant::latest()->paginate(10);
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
    public function store(Request $request)
    {
        $validatedParticipant = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:participants',
            'event_id' => 'required|exists:events,id',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        Participant::create($validatedParticipant);


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
    public function update(Request $request, Participant $participant)
    {

        $participant = Participant::findOrFail($participant->id);

        $validatedParticipant = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:participants,email,' . $participant->id,
            'event_id' => 'required|exists:events,id',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $participant->update($validatedParticipant);

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
            'message' => 'Participant Deleted successful!',
            'alert-type' => 'success'
        ]);
    }
}
