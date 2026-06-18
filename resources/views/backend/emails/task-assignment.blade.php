@extends('backend.emails.layout')

@section('content')

<h2 style="margin:0 0 12px 0;color:#111827;font-size:22px;font-weight:700;line-height:30px;">
    New Task Assigned 📋
</h2>

<p style="margin:0 0 24px 0;color:#4b5563;font-size:16px;line-height:24px;">
    Hello {{ $task->assignee->name }}, a new assignment requires your review and processing.
</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#fff7ed;border:1px solid #ffedd5;border-radius:12px;overflow:hidden;margin-bottom:30px;">
    <tr>
        <td style="padding:16px 20px;border-bottom:1px solid #ffedd5;">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" style="font-size:14px;font-weight:600;color:#9a3412;text-transform:uppercase;">📋 Title</td>
                    <td style="font-size:15px;font-weight:600;color:#7c2d12;">{{ $task->title }}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding:16px 20px;border-bottom:1px solid #ffedd5;">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" style="font-size:14px;font-weight:600;color:#9a3412;text-transform:uppercase;">📝 Brief</td>
                    <td style="font-size:15px;color:#431407;line-height:22px;">{{ $task->description }}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding:16px 20px;">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" style="font-size:14px;font-weight:600;color:#9a3412;text-transform:uppercase;">⏰ Due Date</td>
                    <td style="font-size:15px;font-weight:700;color:#991b1b;">{{ $task->due_date }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

{{-- <table width="100%" cellpadding="0" cellspacing="0" border="0" style="text-align:center;">
    <tr>
        <td>
            <a href="{{ url('/tasks/'.$task->id) }}" style="display:inline-block;background-color:#ea580c;color:#ffffff;padding:14px 32px;font-size:15px;font-weight:600;text-decoration:none;border-radius:8px;box-shadow:0 4px 6px -1px rgba(234,88,12,0.2);">
                Open Task Space
            </a>
        </td>
    </tr>
</table> --}}

@endsection
