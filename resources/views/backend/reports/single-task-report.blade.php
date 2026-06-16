<!DOCTYPE html>
<html>
<head>
    <title>Task Execution Blueprint - #{{ $task->id }}</title>
    <style>
        /* Base Styling & Modern Dashboard Layout */
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #2d3748; font-size: 12px; line-height: 1.6; margin: 0; padding: 25px; background-color: #ffffff; }
        .dashboard-container { border: 1px solid #e2e8f0; border-radius: 6px; background-color: #ffffff; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); overflow: hidden; }
        
        /* Top Status Indicator Accent Bar */
        .status-bar { height: 4px; background-color: #3182ce; }
        .status-pending { background-color: #dd6b20; }
        .status-in_progress { background-color: #3182ce; }
        .status-completed { background-color: #38a169; }

        /* Document Header Design */
        .header-block { padding: 25px 30px; background-color: #f7fafc; border-bottom: 1px solid #e2e8f0; }
        .meta-trace-id { font-size: 10px; font-weight: bold; color: #4a5568; letter-spacing: 1px; text-transform: uppercase; margin: 0; }
        .main-task-title { font-size: 22px; font-weight: 700; color: #1a202c; margin: 6px 0 0 0; line-height: 1.3; }
        
        /* Core Details Presentation Section */
        .content-body { padding: 30px; }
        .section-label-header { font-size: 11px; font-weight: bold; color: #718096; letter-spacing: 0.5px; text-transform: uppercase; margin-bottom: 12px; border-bottom: 1px solid #edf2f7; padding-bottom: 6px; }
        
        /* Structural Data Grid Table */
        .specs-grid-table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        .specs-grid-table td { padding: 10px 0; border-bottom: 1px dashed #edf2f7; vertical-align: top; }
        .specs-grid-table tr:last-child td { border-bottom: none; }
        .column-field-label { font-weight: bold; color: #4a5568; width: 30%; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; }
        .column-field-data { color: #2d3748; font-size: 13px; }
        
        /* Modern Contextual Status Badge */
        .badge-status { display: inline-block; font-size: 10px; font-weight: bold; padding: 2px 8px; border-radius: 4px; text-transform: uppercase; letter-spacing: 0.5px; }
        .badge-pending { background-color: #feebc8; color: #c05621; }
        .badge-in_progress { background-color: #ebf8ff; color: #2b6cb0; }
        .badge-completed { background-color: #c6f6d5; color: #2f855a; }

        /* Operator Comments block quote layout */
        .comments-block-container { margin-top: 25px; background: #f7fafc; border: 1px solid #e2e8f0; border-left: 4px solid #4a5568; padding: 20px; border-radius: 0 4px 4px 0; }
        .comments-title { font-weight: bold; color: #4a5568; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
        .comments-narrative-text { color: #4a5568; font-style: italic; font-size: 12px; line-height: 1.7; }
    </style>
</head>
<body>

    <div class="dashboard-container">
        <!-- Dynamic Top Accent Status Bar Line Color mapping -->
        <div class="status-bar status-{{ $task->status }}"></div>

        <!-- Document Header Area -->
        <div class="header-block">
            <span class="meta-trace-id">Trace Execution Reference: TSK-00{{ $task->id }}</span>
            <h1 class="main-task-title">{{ $task->title }}</h1>
        </div>

        <div class="content-body">
            <!-- Technical Metrics Grid Assignment section -->
            <div class="section-label-header">Deployment Specifications</div>
            
            <table class="specs-grid-table">
                <tr>
                    <td class="column-field-label">Linked Context Event</td>
                    <td class="column-field-data" style="color: #2b6cb0; font-weight: 500;">
                        {{ $task->event->event_name ?? 'Global Operation (Unlinked)' }}
                    </td>
                </tr>
                <tr>
                    <td class="column-field-label">Assigned Resource Operator</td>
                    <td class="column-field-data">
                        <strong>{{ $task->assignee->name ?? 'System Processing Queue' }}</strong>
                    </td>
                </tr>
                <tr>
                    <td class="column-field-label">Execution Deadline Target</td>
                    <td class="column-field-data" style="color: #e53e3e; font-weight: bold;">
                        {{ \Carbon\Carbon::parse($task->due_date)->format('F d, Y') }}
                    </td>
                </tr>
                <tr>
                    <td class="column-field-label">Current Progress Status</td>
                    <td class="column-field-data">
                        <!-- Dynamic Context Class layout framework mapping wrapper -->
                        <span class="badge-status badge-{{ $task->status }}">
                            {{ str_replace('_', ' ', $task->status) }}
                        </span>
                    </td>
                </tr>
            </table>

            <!-- Structural Log Comments Node section layout block execution validation -->
            @if($task->comment)
                <div class="section-label-header">Execution Logs</div>
                <div class="comments-block-container">
                    <div class="comments-title">Operator Feedback Notes</div>
                    <div class="comments-narrative-text">“ {{ $task->comment }} ”</div>
                </div>
            @endif
        </div>
    </div>

</body>
</html>
