@extends('backend.layout.main')

@section('content')
  {{-- Add-event model form --}}
  <div class="modal fade" id="tasksUserModal" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title btn btn-outline-secondary">Add Task</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          @include('backend.tasks.create')
        </div>
      </div>
    </div>
  </div>
  {{-- // Main content area --}}
  <main class="dashboard-content">
    <div class="container-fluid px-3 px-lg-4 py-4">
      <div class="page-heading">
        <div class="page-heading-copy">
          <span class="page-icon"><i class="bi bi-table" aria-hidden="true"></i></span>
          <div>
            <p class="eyebrow mb-1">Data</p>
            <h1 class="h3 mb-1">Tasks</h1>
          </div>
        </div>

        @can('task.create')
          <button class="btn btn-outline-primary btn-sm d-flex justify-content-end" data-bs-toggle="modal"
            data-bs-target="#tasksUserModal">
            <i class="bi bi-person-plus" aria-hidden="true"></i> Add Task
          </button>
        @endcan
      </div>


      <section class="panel">
        <div class="panel-header">

          <div class="d-flex align-items-center gap-3">
            <input class="form-control form-control-sm table-search" type="search" placeholder="Search tasks"
              data-table-search="tasksTable" aria-label="Search tasks">

            <form method="GET" action="{{ route('tasks.index') }}" class="m-0">
              <select name="status" class="form-select form-select-sm" onchange="this.form.submit()"
                style="width: 180px;">
                <option value="">Filter Status</option>

                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                  Pending
                </option>

                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>
                  In Progress
                </option>

                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                  Completed
                </option>
              </select>
            </form>

            <form action="{{ url()->current() }}" method="GET" class="m-0">
              <select name="event_id" class="form-select form-select-sm" onchange="this.form.submit()"
                style="width:220px;">
                <option value="">All Events</option>
                @foreach($events as $event)
                  <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>
                    {{ $event->event_name }}
                  </option>
                @endforeach
              </select>
            </form>

            <!-- Clear Filter Button -->
            @if(request('event_id'))
              <a href="{{ url()->current() }}" class="btn btn-sm btn-outline-danger px-2" title="Clear Filter">
                <i class="fa-solid fa-xmark"></i>
              </a>
            @endif
          </div>

          <a href="{{ route('tasks.pdf.all') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-download" aria-hidden="true"></i>
            Export PDF
          </a>

        </div>

        <div class="table-responsive ">
          <table class="table align-middle mb-0" id="tasksTable" data-searchable-table>
            <thead>
              <tr>
                <th>#</th>
                <th>Task Title </th>
                <th>Event Name</th>
                <th>Assign Task</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              @foreach ($tasks as $task)
                        <tr>
                          <td class="fw-semibold">{{ $loop->iteration }}</td>
                          <td>{{ $task->title }}</td>
                          <td>{{ $task->event->event_name ?? 'No Event Selected' }}</td>
                          <td>{{ $task->assignee->name ?? '-' }}</td>
                          <td>{{ $task->due_date }}</td>
                          <td>
                            <span class="badge        
                                                                                                                                               {{ $task->status == 'pending' ? 'bg-primary' :
                ($task->status == 'in_progress' ? 'bg-success' :
                  ($task->status == 'completed' ? 'bg-info' : 'bg-danger')) }}">

                              {{-- Php function str_replace --}}
                              {{ ucwords(str_replace('_', ' ', $task->status)) }}
                            </span>
                          </td>
                          <td style="white-space: nowrap;">
                            @can('task.assign')
                              <button class="btn btn-outline-dark btn-sm " data-bs-toggle="modal"
                                data-bs-target="#assigncreateTaskModal{{ $task->id }}" title="Assign Task">
                                <i class="bi bi-person-plus" aria-hidden="true"></i>
                              </button>
                            @endcan

                            @can('task.edit')
                              <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editTaskModal{{ $task->id }}" title="Edit Task">
                                <i class="bi bi-pencil-square" aria-hidden="true"></i>
                              </button>
                            @endcan

                            @can('task.delete')
                              <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm"
                                  onclick="return confirm('Are you sure you want to delete this task?')" title="Delete Task">
                                  <i class="bi bi-trash" aria-hidden="true"></i>
                                </button>
                              </form>
                            @endcan

                            @can('task.view')
                              <a class="btn btn-outline-info btn-sm" href="{{ route('tasks.show', $task->id) }}" title="View Task">
                                <i class="bi bi-eye" aria-hidden="true"></i>
                              </a>
                            @endcan
                          </td>

                        </tr>
                        @include('backend.tasks.edit', ['task' => $task])
                        @include('backend.tasks.assigncreate', ['task' => $task])
              @endforeach
            </tbody>
          </table>
        </div>

        {{-- Pagination controls --}}
        <div class="d-flex justify-content-end mt-3">
          {{ $tasks->links('pagination::bootstrap-4') }}
        </div>
      </section>
    </div>
  </main>


@endsection