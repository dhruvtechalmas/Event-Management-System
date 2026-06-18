@extends('backend.emails.layout')

@section('content')

<h2 style="margin:0 0 12px 0;color:#111827;font-size:22px;font-weight:700;line-height:30px;">
    Hello {{ $participant->full_name }} 👋
</h2>

<p style="margin:0 0 24px 0;color:#4b5563;font-size:16px;line-height:24px;">
    We are delighted to invite you to participate in our upcoming event. Please review the details below:
</p>

<!-- Information Card Matrix -->
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;margin-bottom:30px;">
    <tr>
        <td style="padding:16px 20px;border-bottom:1px solid #e2e8f0;">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" style="font-size:14px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;">📌 Event</td>
                    <td style="font-size:15px;font-weight:600;color:#0f172a;">{{ $event->event_name }}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding:16px 20px;border-bottom:1px solid #e2e8f0;">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" style="font-size:14px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;">📅 Date</td>
                    <td style="font-size:15px;color:#334155;">{{ $event->event_date }}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding:16px 20px;border-bottom:1px solid #e2e8f0;">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" style="font-size:14px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;">⏰ Time</td>
                    <td style="font-size:15px;color:#334155;">{{ $event->event_time }}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding:16px 20px;">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" style="font-size:14px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;">📍 Location</td>
                    <td style="font-size:15px;color:#334155;">{{ $event->event_location }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

{{-- <!-- Call To Action Button -->
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="text-align:center;">
    <tr>
        <td>
            <a href="{{ url('/events/'.$event->id) }}" style="display:inline-block;background-color:#4f46e5;color:#ffffff;padding:14px 32px;font-size:15px;font-weight:600;text-decoration:none;border-radius:8px;box-shadow:0 4px 6px -1px rgba(79,70,229,0.2);">
                View Event Details
            </a>
        </td>
    </tr>
</table> --}}

@endsection
