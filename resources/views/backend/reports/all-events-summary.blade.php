<!DOCTYPE html>
<html>
<head>
    <title>All Events Summary</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; color: #333; font-size: 12px; line-height: 1.5; margin: 20px; }
        .header { border-bottom: 3px solid #1a56db; padding-bottom: 10px; margin-bottom: 25px; }
        .title { font-size: 22px; font-weight: bold; color: #1a56db; margin: 0; text-transform: uppercase; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background-color: #1a56db; color: white; padding: 10px; font-weight: bold; text-align: left; font-size: 11px; text-transform: uppercase; }
        td { padding: 10px; border-bottom: 1px solid #e5e7eb; }
        tr:nth-child(even) { background-color: #f9fafb; }
        .badge { display: inline-block; padding: 2px 6px; font-size: 10px; font-weight: bold; border-radius: 4px; background: #e0e7ff; color: #4338ca; }
    </style>
</head>
<body>
    <div class="header">
        <table style="width: 100%; border: none;">
            <tr>
                <td style="border: none; padding: 0;"><h1 class="title">All Events Summary Report</h1></td>
                <td style="border: none; padding: 0; text-align: right; color: #666; font-size: 10px;">Generated: {{ now()->format('Y-m-d H:i') }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 8%;">ID</th>
                <th style="width: 32%;">Event Name</th>
                <th style="width: 20%;">Type</th>
                <th style="width: 25%;">Location</th>
                <th style="width: 15%;">Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
            <tr>
                <td><strong>#{{ $event->id }}</strong></td>
                <td>{{ $event->event_name }}</td>
                <td><span class="badge">{{ $event->event_type ?? 'General' }}</span></td>
                <td>{{ $event->event_location ?? 'Not Specified' }}</td>
                <td>{{ \Carbon\Carbon::parse($event->event_date)->format('Y-m-d') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: #666;">No event records discovered in the system database.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
