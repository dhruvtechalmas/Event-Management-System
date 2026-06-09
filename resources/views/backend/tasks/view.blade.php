@extends('backend.layout.main')

@section('content')

@php
    $color = '#' . substr(md5($task->title), 0, 6);
@endphp

<main class="dashboard-content">

    <div class="container-fluid px-3 px-lg-4 py-4">

        <div class="page-heading">
            <div class="page-heading-copy">
                <span class="page-icon">
                    <i class="bi bi-list-task"></i>
                </span>

                <div>
                    <p class="eyebrow mb-1">Management</p>
                    <h1 class="h3 mb-1">Task Details</h1>
                    <p class="text-muted mb-0">
                        Inspect task information, assignee details and status.
                    </p>
                </div>
            </div>

            <div class="heading-actions">
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i>
                    Back to Tasks
                </a>
            </div>
        </div>

        <section class="row g-3">

            <!-- Left Card -->
            <div class="col-12 col-xl-4">

                <div class="panel h-100 text-center profile-card">

                    <div class="profile-cover"></div>

                    <div class="profile-hero">

                        <div class="profile-avatar" style="background-color: {{ $color }}">
                            {{ strtoupper(substr($task->title, 0, 1)) }}
                        </div>

                        <h2 class="h5 mt-3 mb-1">
                            {{ $task->title }}
                        </h2>

                        <p class="text-muted mb-3">
                            {{ $task->event->event_name ?? 'No Event' }}
                        </p>

                        <span class="badge
                            {{ $task->status == 'pending' ? 'bg-primary' :
                            ($task->status == 'in_progress' ? 'bg-success' :
                            ($task->status == 'completed' ? 'bg-info' : 'bg-danger')) }}">
                            {{ ucwords(str_replace('_', ' ', $task->status)) }}
                        </span>

                    </div>

                    <div class="info-list mt-4 text-start">

                        <div>
                            <span>Task Title</span>
                            <strong>{{ $task->title }}</strong>
                        </div>

                        <div>
                            <span>Event</span>
                            <strong>{{ $task->event->event_name ?? 'N/A' }}</strong>
                        </div>

                        <div>
                            <span>Assigned To</span>
                            <strong>{{ $task->assignee->name ?? 'N/A' }}</strong>
                        </div>

                        <div>
                            <span>Due Date</span>
                            <strong>{{ $task->due_date }}</strong>
                        </div>

                        <div>
                            <span>Status</span>
                            <strong>{{ ucwords(str_replace('_', ' ', $task->status)) }}</strong>
                        </div>

                        <div>
                            <span>Created</span>
                            <strong>{{ $task->created_at->format('d M Y') }}</strong>
                        </div>

                    </div>

                </div>

            </div>

            <!-- Right Side -->
            <div class="col-12 col-xl-8">

                <div class="panel mb-3">

                    <div class="panel-header">

                        <div>
                            <h2 class="h5 mb-1 section-title">
                                <i class="bi bi-card-checklist"></i>
                                <span>Task Overview</span>
                            </h2>

                            <p class="text-muted mb-0">
                                Status, due date and assignment details.
                            </p>
                        </div>

                    </div>

                    <div class="row g-3">

                        <div class="col-md-4">
                            <div class="mini-card">
                                <span>Status</span>
                                <strong>
                                    {{ ucwords(str_replace('_', ' ', $task->status)) }}
                                </strong>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mini-card">
                                <span>Task ID</span>
                                <strong>#{{ $task->id }}</strong>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mini-card">
                                <span>Due Date</span>
                                <strong>{{ $task->due_date }}</strong>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- Assigned User -->
                <div class="panel mb-3">

                    <div class="panel-header">
                        <div>
                            <h2 class="h5 mb-1 section-title">
                                <i class="bi bi-person"></i>
                                <span>Assigned User</span>
                            </h2>
                        </div>
                    </div>

                    <div class="info-list">

                        <div>
                            <span>Name</span>
                            <strong>{{ $task->assignee->name ?? 'N/A' }}</strong>
                        </div>

                        <div>
                            <span>Email</span>
                            <strong>{{ $task->assignee->email ?? 'N/A' }}</strong>
                        </div>

                        <div>
                            <span>Phone</span>
                            <strong>{{ $task->assignee->phone ?? 'N/A' }}</strong>
                        </div>

                        <div>
                            <span>Role</span>
                            <strong>
                                {{ $task->assignee?->getRoleNames()->first() ?? 'N/A' }}
                            </strong>
                        </div>

                    </div>

                </div>

                <!-- Comment -->
                <div class="panel">

                    <div class="panel-header">
                        <div>
                            <h2 class="h5 mb-1 section-title">
                                <i class="bi bi-chat-left-text"></i>
                                <span>Task Comment</span>
                            </h2>
                        </div>
                    </div>

                    <p class="mb-0">
                        {{ $task->comment ?? 'No comment available.' }}
                    </p>

                </div>

            </div>

        </section>

    </div>

</main>

<style>
.profile-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    color: white;
    font-size: 38px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: auto;
    border: 4px solid #fff;
    box-shadow: 0 4px 15px rgba(0,0,0,.15);
}
</style>

@endsection