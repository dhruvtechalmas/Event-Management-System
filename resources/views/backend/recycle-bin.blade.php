@extends('backend.layout.main')

@section('content')

    <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">


            {{-- Page Heading --}}
            <div class="page-heading">
                <div class="page-heading-copy">
                    <span class="page-icon">
                        <i class="bi bi-trash3"></i>
                    </span>

                    <div>
                        <p class="eyebrow mb-1">Deleted Records</p>
                        <h1 class="h3 mb-1">Recycle Bin</h1>
                    </div>
                </div>
            </div>

            <section class="panel">

                <div class="accordion" id="recycleAccordion">

                    {{-- ========================================= --}}
                    {{-- Deleted Events --}}
                    {{-- ========================================= --}}
                    <div class="accordion-item mb-3">

                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#eventsCollapse">

                                <i class="bi bi-calendar-event me-2"></i>
                                Deleted Events
                                ({{ $events->count() }})
                            </button>
                        </h2>

                        <div id="eventsCollapse" class="accordion-collapse collapse show">

                            <div class="accordion-body">

                                <div class="table-responsive">

                                    <table class="table align-middle mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Event Details</th>
                                                <th>Status</th>
                                                <th>Deleted At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @forelse ($events as $event)

                                                                                <tr>

                                                                                    <td class="fw-semibold">
                                                                                        {{ $event->id }}
                                                                                    </td>

                                                                                    <td>

                                                                                        <div class="fw-bold">
                                                                                            {{ $event->event_name }}
                                                                                        </div>

                                                                                        {{-- Deleted Tasks --}}
                                                                                        @if($event->tasks->whereNotNull('deleted_at')->count())

                                                                                            <div class="mt-2">

                                                                                                <small class="fw-bold text-danger">
                                                                                                    Deleted Tasks
                                                                                                </small>

                                                                                                <ul class="mb-0 ps-3">

                                                                                                    @foreach($event->tasks as $task)

                                                                                                        @if($task->trashed())

                                                                                                            <li>
                                                                                                                {{ $task->title }}
                                                                                                            </li>

                                                                                                        @endif

                                                                                                    @endforeach

                                                                                                </ul>

                                                                                            </div>

                                                                                        @endif

                                                                                        {{-- Deleted Participants --}}
                                                                                        @if($event->participants->whereNotNull('deleted_at')->count())

                                                                                            <div class="mt-2">

                                                                                                <small class="fw-bold text-danger">
                                                                                                    Deleted Participants
                                                                                                </small>

                                                                                                <ul class="mb-0 ps-3">

                                                                                                    @foreach($event->participants as $participant)

                                                                                                        @if($participant->trashed())

                                                                                                            <li>
                                                                                                                {{ $participant->full_name }}
                                                                                                            </li>

                                                                                                        @endif

                                                                                                    @endforeach

                                                                                                </ul>

                                                                                            </div>

                                                                                        @endif

                                                                                    </td>

                                                                                    <td>

                                                                                        <span class="badge
                                                                                                                                                                                                                    {{ $event->status == 'Draft' ? 'bg-secondary' :
                                                ($event->status == 'Upcoming' ? 'bg-primary' :
                                                    ($event->status == 'Ongoing' ? 'bg-success' :
                                                        ($event->status == 'Completed' ? 'bg-info' :
                                                            'bg-danger'))) }}">

                                                                                            {{ $event->status }}

                                                                                        </span>

                                                                                    </td>

                                                                                    <td>
                                                                                        {{ $event->deleted_at->diffForHumans() }}
                                                                                    </td>

                                                                                    <td style="white-space: nowrap;">

                                                                                        <form action="{{ route('recycle.events.restore', $event->id) }}"
                                                                                            method="POST" class="d-inline">

                                                                                            @csrf
                                                                                            @method('PATCH')

                                                                                            <button class="btn btn-outline-success btn-sm" title="Restore">

                                                                                                <i class="bi bi-arrow-clockwise"></i>

                                                                                            </button>

                                                                                        </form>

                                                                                        <form action="{{ route('recycle.events.force-delete', $event->id) }}"
                                                                                            method="POST" class="d-inline">

                                                                                            @csrf
                                                                                            @method('DELETE')

                                                                                            <button class="btn btn-outline-danger btn-sm"
                                                                                                title="Delete Permanently"
                                                                                                onclick="return confirm('Delete permanently?')">

                                                                                                <i class="bi bi-trash"></i>

                                                                                            </button>

                                                                                        </form>

                                                                                    </td>

                                                                                </tr>

                                            @empty

                                                <tr>
                                                    <td colspan="5" class="text-center text-muted py-4">

                                                        No deleted events found.

                                                    </td>
                                                </tr>

                                            @endforelse

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- ========================================= --}}
                    {{-- Deleted Tasks --}}
                    {{-- ========================================= --}}
                    <div class="accordion-item mb-3">

                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#tasksCollapse">

                                <i class="bi bi-list-task me-2"></i>
                                Deleted Tasks
                                ({{ $tasks->count() }})
                            </button>
                        </h2>

                        <div id="tasksCollapse" class="accordion-collapse collapse">

                            <div class="accordion-body">

                                <div class="table-responsive">

                                    <table class="table align-middle mb-0">

                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Task</th>
                                                <th>Event Name</th>
                                                <th>Deleted At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @forelse ($tasks as $task)

                                                <tr>

                                                    <td>{{ $task->id }}</td>

                                                    <td>{{ $task->title }}</td>
                                                    <td>
                                                        @if($task->event)
                                                            <span class="badge bg-secondary">
                                                                {{ $task->event->event_name }}
                                                            </span>
                                                        @else
                                                            <span class="badge bg-info">
                                                                Individually Deleted
                                                            </span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        {{ $task->deleted_at->diffForHumans() }}
                                                    </td>

                                                    <td>

                                                        <form action="{{ route('recycle.tasks.restore', $task->id) }}"
                                                            method="POST" class="d-inline">

                                                            @csrf
                                                            @method('PATCH')

                                                            <button class="btn btn-outline-success btn-sm">

                                                                <i class="bi bi-arrow-clockwise"></i>

                                                            </button>

                                                        </form>

                                                        <form action="{{ route('recycle.tasks.force-delete', $task->id) }}"
                                                            method="POST" class="d-inline">

                                                            @csrf
                                                            @method('DELETE')

                                                            <button class="btn btn-outline-danger btn-sm"
                                                                onclick="return confirm('Delete permanently?')">

                                                                <i class="bi bi-trash"></i>

                                                            </button>

                                                        </form>

                                                    </td>

                                                </tr>

                                            @empty

                                                <tr>
                                                    <td colspan="4" class="text-center text-muted py-4">

                                                        No deleted tasks found.

                                                    </td>
                                                </tr>

                                            @endforelse

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- ========================================= --}}
                    {{-- Deleted Participants --}}
                    {{-- ========================================= --}}
                    <div class="accordion-item">

                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#participantsCollapse">

                                <i class="bi bi-people me-2"></i>
                                Deleted Participants
                                ({{ $participants->count() }})
                            </button>
                        </h2>

                        <div id="participantsCollapse" class="accordion-collapse collapse">

                            <div class="accordion-body">

                                <div class="table-responsive">

                                    <table class="table align-middle mb-0">

                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Participant</th>
                                                <th>Email</th>
                                                <th>Event Name</th>
                                                <th>Deleted At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @forelse ($participants as $participant)

                                                <tr>

                                                    <td>{{ $participant->id }}</td>

                                                    <td>
                                                        {{ $participant->full_name }}
                                                    </td>

                                                    <td>
                                                        {{ $participant->email }}
                                                    </td>


                                                    <td>
                                                        @if($participant->event)
                                                            <span class="badge bg-secondary">
                                                                {{ $participant->event->event_name }}
                                                            </span>
                                                        @else
                                                            <span class="badge bg-info">
                                                                Individually Deleted
                                                            </span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        {{ $participant->deleted_at->diffForHumans() }}
                                                    </td>

                                                    <td>

                                                        <form
                                                            action="{{ route('recycle.participants.restore', $participant->id) }}"
                                                            method="POST" class="d-inline">

                                                            @csrf
                                                            @method('PATCH')

                                                            <button class="btn btn-outline-success btn-sm">

                                                                <i class="bi bi-arrow-clockwise"></i>

                                                            </button>

                                                        </form>

                                                        <form
                                                            action="{{ route('recycle.participants.force-delete', $participant->id) }}"
                                                            method="POST" class="d-inline">

                                                            @csrf
                                                            @method('DELETE')

                                                            <button class="btn btn-outline-danger btn-sm"
                                                                onclick="return confirm('Delete permanently?')">

                                                                <i class="bi bi-trash"></i>

                                                            </button>

                                                        </form>

                                                    </td>

                                                </tr>

                                            @empty

                                                <tr>
                                                    <td colspan="5" class="text-center text-muted py-4">

                                                        No deleted participants found.

                                                    </td>
                                                </tr>

                                            @endforelse

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </section>

        </div>


    </main>

@endsection