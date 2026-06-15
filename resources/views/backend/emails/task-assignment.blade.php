@extends('backend.emails.layout')

@section('content')

<h2 style="margin-top:0;color:#111827;">
    Hello {{ $task->assignee->name }} 👋
</h2>

<p style="color:#6b7280;">
    A new task has been assigned to you.
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
            <strong>📋 Task</strong>
        </td>
        <td>
            {{ $task->title }}
        </td>
    </tr>

    <tr>
        <td>
            <strong>📝 Description</strong>
        </td>
        <td>
            {{ $task->description }}
        </td>
    </tr>

    <tr>
        <td>
            <strong>📅 Due Date</strong>
        </td>
        <td>
            {{ $task->due_date }}
        </td>
    </tr>

</table>

@endsection