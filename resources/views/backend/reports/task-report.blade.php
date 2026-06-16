<!DOCTYPE html>
<html>
<head>
    <title>Global Task Analysis Matrix</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; color: #333; font-size: 11px; margin: 20px; }
        .header { border-bottom: 3px solid #dc2626; padding-bottom: 10px; margin-bottom: 20px; }
        .title { font-size: 22px; font-weight: bold; color: #dc2626; margin: 0; text-transform: uppercase; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background-color: #dc2626; color: white; padding: 8px; text-align: left; font-size: 11px; text-transform: uppercase; }
        td { padding: 8px; border-bottom: 1px solid #e5e7eb; }
        tr:nth-child(even) { background-color: #fff5f5; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">Global Operational Tasks Report</h1>
        <div style="font-size: 10px; color: #666;">Generated Matrix Pipeline Stream • Check Status Synchronization</div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 25%;">Task Title</th>
                <th style="width: 25%;">Associated Event</th>
                <th style="width: 20%;">Assigned Operator</th>
                <th style="width: 15%;">Deadline</th>
                <th style="width: 15%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tasks as $task)
            <tr>
                <td><strong>{{ $task->title }}</strong></td>
                <td>{{ $task->event->event_name ?? 'N/A' }}</td>
                <td>{{ $task->assignedTo->name ?? 'Unassigned' }}</td>
                <td>{{ \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') }}</td>
                <td><span style="text-transform: uppercase; font-weight: bold; font-size: 9px;">{{ str_replace('_', ' ', $task->status) }}</span></td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: #666; padding: 20px;">No operational task dependencies are presently declared.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
