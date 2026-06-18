<!DOCTYPE html>
<html>
<head>
    <title>Participant Roster</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; color: #333; font-size: 11px; margin: 20px; }
        .header { border-bottom: 3px solid #4f46e5; padding-bottom: 10px; margin-bottom: 20px; }
        .title { font-size: 22px; font-weight: bold; color: #4f46e5; margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background-color: #4f46e5; color: white; padding: 8px; font-size: 11px; text-align: left; text-transform: uppercase; }
        td { padding: 8px; border-bottom: 1px solid #e5e7eb; vertical-align: top; }
        tr:nth-child(even) { background-color: #f9fafb; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">Official Participant Roster</h1>
        <div style="font-size: 11px; color: #666; margin-top: 5px;">Target Event Profile: <strong>{{ $event->event_name }}</strong></div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 25%;">Full Name</th>
                <th style="width: 25%;">Email</th>
                <th style="width: 15%;">Phone</th>
                <th style="width: 30%;">Address / Notes</th>
            </tr>
        </thead>
        <tbody>
            @forelse($participants as $index => $participant)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><strong>{{ $participant->full_name }}</strong></td>
                <td>{{ $participant->email }}</td>
                <td>{{ $participant->phone ?? 'N/A' }}</td>
                <td>
                    <span style="color: #4b5563;">{{ $participant->address }}</span>
                    @if($participant->notes)<br><small style="color: #888; font-style: italic;">Note: {{ $participant->notes }}</small>@endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: #666; padding: 20px;">No registered allocations matched inside this query filter context.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
