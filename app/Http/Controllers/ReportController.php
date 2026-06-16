<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;
use App\Models\Task;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function downloadAllEventsSummary()
    {
        $events = Event::all();
        $pdf = Pdf::loadView('backend.reports.all-events-summary', compact('events'));
        return $pdf->download("all-events-summary.pdf");
    }

    public function downloadEventSummary($id)
    {
        $event = Event::with(['tasks', 'participants'])->findOrFail($id);
        $pdf = Pdf::loadView('backend.reports.event-summary', compact('event'));
        return $pdf->download("event-summary-{$id}.pdf");
    }


   public function downloadAllTasksReport()
    {
        $tasks = Task::with(['assignee', 'event'])->get();
        $pdf = Pdf::loadView('backend.reports.task-report', compact('tasks'));
        return $pdf->download("global-task-report.pdf");
    }

    public function downloadSingleTaskReport($id)
    {
        $task = Task::with(['assignee', 'event'])->findOrFail($id);
        $pdf = Pdf::loadView('backend.reports.single-task-report', compact('task'));
        return $pdf->download("task-report-{$id}.pdf");
    }
}

