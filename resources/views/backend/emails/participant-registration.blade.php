@extends('backend.emails.layout')

@section('content')

<h2 style="margin:0 0 12px 0;color:#111827;font-size:22px;font-weight:700;line-height:30px;">
    Success! 🎉
</h2>

<h4 style="margin:0 0 24px 0;color:#1e232e;font-size:16px;line-height:24px;">
    Hello {{ $participant->full_name }},
</h4>

<p style="margin:0 0 24px 0;color:#4b5563;font-size:16px;line-height:24px;">
    your registration pass has been confirmed successfully. Here is your summary configuration:
</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;overflow:hidden;margin-bottom:24px;">
    <tr>
        <td style="padding:16px 20px;border-bottom:1px solid #bbf7d0;">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" style="font-size:14px;font-weight:600;color:#166534;text-transform:uppercase;">📌 Event</td>
                    <td style="font-size:15px;font-weight:600;color:#14532d;">{{ $event->event_name }}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding:16px 20px;border-bottom:1px solid #bbf7d0;">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" style="font-size:14px;font-weight:600;color:#166534;text-transform:uppercase;">📅 Date</td>
                    <td style="font-size:15px;color:#14532d;">{{ $event->event_date }}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding:16px 20px;">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" style="font-size:14px;font-weight:600;color:#166534;text-transform:uppercase;">📍 Location</td>
                    <td style="font-size:15px;color:#14532d;">{{ $event->event_location }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<p style="margin:24px 0 0 0;color:#6b7280;font-size:15px;line-height:24px;text-align:center;">
    We are excited to have you join us. Please show this email upon arrival.
</p>

@endsection
