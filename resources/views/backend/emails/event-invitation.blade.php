@extends('backend.emails.layout')

@section('content')

<h2 style="
    margin-top:0;
    color:#111827;
    font-size:24px;
">
    Hello {{ $participant->full_name }} 👋
</h2>

<p style="color:#6b7280;">
    We are delighted to invite you to participate in the following event.
</p>

<table width="100%" cellpadding="12" cellspacing="0"
    style="
        margin-top:25px;
        background:#f8fafc;
        border:1px solid #e5e7eb;
        border-radius:12px;
    ">

    <tr>
        <td width="35%">
            <strong>📌 Event</strong>
        </td>
        <td>{{ $event->event_name }}</td>
    </tr>

    <tr>
        <td>
            <strong>📅 Date</strong>
        </td>
        <td>{{ $event->event_date }}</td>
    </tr>

    <tr>
        <td>
            <strong>⏰ Time</strong>
        </td>
        <td>{{ $event->event_time }}</td>
    </tr>

    <tr>
        <td>
            <strong>📍 Location</strong>
        </td>
        <td>{{ $event->event_location }}</td>
    </tr>

</table>

@endsection