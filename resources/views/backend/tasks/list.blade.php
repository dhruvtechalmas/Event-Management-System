@extends('backend.layout.main')

@section('content')
  {{-- Add-event model form --}}
  <div class="modal fade" id="tasksUserModal" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title btn btn-outline-dark">Add Task</h5>
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
        <button class="btn btn-primary btn-sm d-flex justify-content-end" data-bs-toggle="modal"
          data-bs-target="#tasksUserModal">
          <i class="bi bi-person-plus" aria-hidden="true"></i> Add Task
        </button>
        @endcan

      </div>



      <section class="panel">
        <div class="panel-header"><input class="form-control form-control-sm table-search" type="search"
            placeholder="Search tasks" data-table-search="tasksTable" aria-label="Search tasks">
        </div>

        <div class="table-responsive ">
          <table class="table align-middle mb-0" id="tasksTable" data-searchable-table>
            <thead>
              <tr>
                <th class="text-dark">#</th>
                <th class="text-dark">Task Title </th>
                <th class="text-dark">Event Name</th>
                <th class="text-dark">Assign Task</th>
                <th class="text-dark">Due Date</th>
                <th class="text-dark">Status</th>
                <th class="text-dark text-center">Action</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              @foreach ($tasks as $task)
                        <tr>
                          <td class="fw-semibold">{{ $task->id }}</td>
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
                          <td>
                            @can('task.assign')
                              
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                            data-bs-target="#assigncreateTaskModal{{ $task->id }}">
                            Assign
                          </button>
                          @endcan
                            
                            @can('task.edit')
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                              data-bs-target="#editTaskModal{{ $task->id }}">
                              Edit
                            </button>
                            @endcan

                            @can('task.delete')
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display: inline;">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this participant?')">
                                Delete
                              </button>
                            </form>
                            @endcan

                            @can('task.view')                             
                            <a class="btn btn-light btn-sm" href="{{ route('tasks.show', $task->id) }}">View</a>
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