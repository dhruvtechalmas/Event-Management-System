@extends('backend.layout.main')

@section('content')

  {{-- Add-event model form --}}
  <div class="modal fade" id="eventUserModal" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title btn btn-outline-dark">Add Event</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          @include('backend.events.create')
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
            <h1 class="h3 mb-1">Events</h1>
          </div>
        </div>

        @can('event.create')
          <button class="btn btn-outline-primary btn-sm d-flex justify-content-end" data-bs-toggle="modal"
            data-bs-target="#eventUserModal">
            <i class="bi bi-person-plus" aria-hidden="true"></i> Add Event
          </button>
        @endcan
      </div>


      <section class="panel">
        <div class="panel-header ">
          <input class="form-control form-control-sm table-search" type="search" placeholder="Search events"
            data-table-search="eventsTable" aria-label="Search events">

          <!-- Single Event PDF Export Button -->
          <a href="{{ route('events.pdf.all') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-download" aria-hidden="true"></i> Export PDF
          </a>

        </div>

        <div class="table-responsive">
          <table class="table align-middle mb-0" id="eventsTable" data-searchable-table>
            <thead>
              <tr>
                <th class="text-dark">#</th>
                <th class="text-dark">Event Name</th>
                <th class="text-dark">Event Type</th>
                <th class="text-dark">Event Date</th>
                <th class="text-dark">Event Time</th>
                <th class="text-dark">Event Status</th>
                <th class="text-dark ">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($events as $event)
                        <tr>
                          <td class="fw-semibold">{{ $event->id }}</td>
                          <td class="text-dark">{{ $event->event_name }}</td>
                          <td>{{ $event->event_type }}</td>
                          <!-- Date Only -->
                          <td style="white-space: nowrap;">
                            <i class="bi bi-calendar3 text-primary me-2"></i>
                            <span class="fw-bold">{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</span>
                          </td>


                          <!-- Time Only -->
                          <td style="white-space: nowrap;">
                            <i class="bi bi-clock text-secondary me-2"></i>
                            <span class="text-muted small">{{ \Carbon\Carbon::parse($event->event_time)->format('H:i:s') }}</span>
                          </td>

                          <td>
                            <span class="badge
                                                                                          {{ $event->status == 'Draft' ? 'bg-secondary' :
                ($event->status == 'Upcoming' ? 'bg-primary' :
                  ($event->status == 'Ongoing' ? 'bg-success' :
                    ($event->status == 'Completed' ? 'bg-info' : 'bg-danger'))) }}">
                              {{ $event->status }}
                            </span>
                          </td>

                         <td style="white-space: nowrap;">
                          @can('event.edit')
                            <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal"
                              data-bs-target="#editEventModal{{ $event->id }}" title="Edit Event">
                              <i class="bi bi-pencil-square" aria-hidden="true"></i>
                            </button>
                          @endcan

                          @can('event.delete')
                            <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display: inline;">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-outline-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this event?')" title="Delete Event">
                                <i class="bi bi-trash" aria-hidden="true"></i>
                              </button>
                            </form>
                          @endcan

                          @can('event.view')
                            <a class="btn btn-outline-info btn-sm" href="{{ route('events.show', $event->id) }}" title="View Details">
                              <i class="bi bi-eye" aria-hidden="true"></i>
                            </a>
                          @endcan
                      </td>
                        </tr>
                        @include('backend.events.edit', ['event' => $event])
              @endforeach
            </tbody>
          </table>
        </div>

        {{-- Pagination controls --}}
        <div class="d-flex justify-content-end mt-3">
          {{ $events->links('pagination::bootstrap-4') }}
        </div>
      </section>
    </div>
  </main>


@endsection