<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;
use App\Models\Task;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // 1. Event Summary PDF
    public function downloadEventSummary($id)
    {
        $event = Event::findOrFail($id);
        $pdf = Pdf::loadView('reports.event-summary', compact('event'));
        return $pdf->download("event-summary-{$id}.pdf");
    }

    // 2. Participant List PDF
    public function downloadParticipantList($eventId)
    {
        $participants = Participant::where('event_id', $eventId)->get();
        $pdf = Pdf::loadView('reports.participant-list', compact('participants'));
        return $pdf->download("participants-event-{$eventId}.pdf");
    }

    // 3. Task Report PDF
    public function downloadTaskReport()
    {
        $tasks = Task::with('user')->get();
        $pdf = Pdf::loadView('reports.task-report', compact('tasks'));
        return $pdf->download("global-task-report.pdf");
    }
}
