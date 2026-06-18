@extends('backend.emails.layout')

@section('content')

<h2 style="margin:0 0 12px 0;color:#111827;font-size:22px;font-weight:700;line-height:30px;">
    Event Reminder ⏰
</h2>

<p style="margin:0 0 24px 0;color:#4b5563;font-size:16px;line-height:24px;">
    Hello {{ $participant->full_name }}, this is a friendly scheduled update regarding your itinerary tracking.
</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f0fdfa;border:1px solid #ccfbf1;border-radius:12px;overflow:hidden;margin-bottom:30px;">
    <tr>
        <td style="padding:16px 20px;border-bottom:1px solid #ccfbf1;">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" style="font-size:14px;font-weight:600;color:#0f766e;text-transform:uppercase;">📌 Target</td>
                    <td style="font-size:15px;font-weight:600;color:#115e59;">{{ $event->event_name }}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding:16px 20px;border-bottom:1px solid #ccfbf1;">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" style="font-size:14px;font-weight:600;color:#0f766e;text-transform:uppercase;">📅 Date</td>
                    <td style="font-size:15px;color:#115e59;">{{ $event->event_date }}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding:16px 20px;border-bottom:1px solid #ccfbf1;">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" style="font-size:14px;font-weight:600;color:#0f766e;text-transform:uppercase;">⏰ Window</td>
                    <td style="font-size:15px;color:#115e59;">{{ $event->event_time }}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding:16px 20px;">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" style="font-size:14px;font-weight:600;color:#0f766e;text-transform:uppercase;">📍 Venue</td>
                    <td style="font-size:15px;color:#115e59;">{{ $event->event_location }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<p style="margin:0;color:#4b5563;font-size:15px;line-height:24px;text-align:center;font-weight:500;">
    We look forward to hosting you soon!
</p>

@endsection
