@extends('emails.layout')

@section('content')

<h2 style="margin-top:0;color:#111827;">
    Hello {{ $participant->full_name }} 👋
</h2>

<p style="color:#6b7280;">
    This is a reminder for your upcoming event.
</p>

<table width="100%"
       cellpadding="12"
       cellspacing="0"
       style="
            background:#f8fafc;
            border:1px solid #e5e7eb;
            border-radius:12px;
       ">

    <tr>
        <td width="35%">
            <strong>📌 Event</strong>
        </td>
        <td>
            {{ $event->event_name }}
        </td>
    </tr>

    <tr>
        <td>
            <strong>📅 Date</strong>
        </td>
        <td>
            {{ $event->event_date }}
        </td>
    </tr>

    <tr>
        <td>
            <strong>⏰ Time</strong>
        </td>
        <td>
            {{ $event->event_time }}
        </td>
    </tr>

    <tr>
        <td>
            <strong>📍 Location</strong>
        </td>
        <td>
            {{ $event->event_location }}
        </td>
    </tr>

</table>

<p style="margin-top:30px;color:#6b7280;">
    We look forward to seeing you.
</p>

@endsection