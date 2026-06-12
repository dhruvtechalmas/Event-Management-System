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

                            <button type="button" class="btn btn-light view-task-btn" data-id="{{ $task->id }}">
                                View Details
                            </button>


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
            box-shadow: 0 4px 15px rgba(0, 0, 0, .15);
        }
    </style>

    <div class="modal fade" id="taskDetailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        Task & Event Details
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <h5 class="text-primary mb-3">
                        Task Details
                    </h5>

                    <table class="table table-bordered">
                        <tr>
                            <th>Title</th>
                            <td id="task_title"></td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td id="task_status"></td>
                        </tr>

                        <tr>
                            <th>Due Date</th>
                            <td id="task_due_date"></td>
                        </tr>

                        <tr>
                            <th>Description</th>
                            <td id="task_description"></td>
                        </tr>

                        <tr>
                            <th>Created At</th>
                            <td id="task_created_at"></td>
                        </tr>
                    </table>

                    <h5 class="text-success mt-4 mb-3">
                        Event Details
                    </h5>

                    <table class="table table-bordered">
                        <tr>
                            <th>Event Name</th>
                            <td id="event_name"></td>
                        </tr>

                        <tr>
                            <th>Event Type</th>
                            <td id="event_type"></td>
                        </tr>

                        <tr>
                            <th>Event Date</th>
                            <td id="event_date"></td>
                        </tr>

                        <tr>
                            <th>Event Time</th>
                            <td id="event_time"></td>
                        </tr>

                        <tr>
                            <th>Event Location</th>
                            <td id="event_location"></td>
                        </tr>

                        <tr>
                            <th>Description</th>
                            <td id="event_description"></td>
                        </tr>
                    </table>

                    <h5 class="text-info mt-4 mb-3">
                        Assigned User
                    </h5>

                    <table class="table table-bordered">
                        <tr>
                            <th>Name</th>
                            <td id="user_name"></td>
                        </tr>

                        <tr>
                            <th>Email</th>
                            <td id="user_email"></td>
                        </tr>

                        <tr>
                            <th>Phone</th>
                            <td id="user_phone"></td>
                        </tr>
                    </table>

                </div>

            </div>
        </div>
    </div>

    <script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelector('.view-task-btn').addEventListener('click', function () {

        let taskId = this.dataset.id;

        fetch(`/tasks/view-details/${taskId}`)
        .then(response => response.json())
        .then(data => {

            // Task
            document.getElementById('task_title').innerText =
                data.task.title ?? '-';

            document.getElementById('task_status').innerText =
                data.task.status ?? '-';

            document.getElementById('task_due_date').innerText =
                data.task.due_date ?? '-';

            document.getElementById('task_description').innerText =
                data.task.description ?? '-';

            document.getElementById('task_created_at').innerText =
                data.task.created_at ?? '-';

            // Event
            document.getElementById('event_name').innerText =
                data.event?.event_name ?? '-';

            document.getElementById('event_type').innerText =
                data.event?.event_type ?? '-';

            document.getElementById('event_date').innerText =
                data.event?.event_date ?? '-';

            document.getElementById('event_time').innerText =
                data.event?.event_time ?? '-';

            document.getElementById('event_location').innerText =
                data.event?.event_location ?? '-';

            document.getElementById('event_description').innerText =
                data.event?.description ?? '-';

            // User
            document.getElementById('user_name').innerText =
                data.assignee?.name ?? '-';

            document.getElementById('user_email').innerText =
                data.assignee?.email ?? '-';

            document.getElementById('user_phone').innerText =
                data.assignee?.phone ?? '-';

            let modal = new bootstrap.Modal(
                document.getElementById('taskDetailModal')
            );

            modal.show();
        });
    });

});
</script>



@endsection