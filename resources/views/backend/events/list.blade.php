@extends('backend.layout.main')

@section('content')

  {{-- Add-event model form --}}
  <div class="modal fade" id="eventUserModal" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title btn btn-outline-secondary">Add Event</h5>
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
        <div class="panel-header">

          <div class="d-flex align-items-center gap-3">
            <input class="form-control form-control-sm table-search" type="search" placeholder="Search events"
              data-table-search="eventsTable" aria-label="Search events">

            <form action="{{ route('events.index') }}" method="GET" class="m-0">
              @if(request('event_date'))
                <input type="hidden" name="event_date" value="{{ request('event_date') }}">
              @endif
              <select name="status" class="form-select form-select-sm" onchange="this.form.submit()" style="width:150px;">
                <option value="">Filter Status</option>
                <option value="Draft" {{ request('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
                <option value="Upcoming" {{ request('status') == 'Upcoming' ? 'selected' : '' }}>Upcoming</option>
                <option value="Ongoing" {{ request('status') == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
              </select>
            </form>

            <form action="{{ route('events.index') }}" method="GET" class="m-0 d-flex align-items-center gap-1">
              @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
              @endif

              <input type="date" name="event_date" value="{{ request('event_date') }}"
                class="form-control form-control-sm" onchange="this.form.submit()" style="width: 160px;">

              @if(request('event_date'))
                <a href="{{ route('events.index', request()->except('event_date')) }}"
                  class="btn btn-sm btn-outline-danger px-2" title="Clear Date">
                  <i class="fa-solid fa-xmark"></i>
                </a>
              @endif
            </form>
          </div>


          <a href="{{ route('events.pdf.all') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-download"></i> Export PDF
          </a>

        </div>

        <div class="table-responsive">
          <table class="table align-middle mb-0" id="eventsTable" data-searchable-table>
            <thead>
              <tr>
                <th>#</th>
                <th>Event Image</th>
                <th>Event Name</th>
                <th>Event Type</th>
                <th>Event Date</th>
                <th>Event Time</th>
                <th>Capacity</th>
                <th>Registered</th>
                <th>Remaining</th>
                <th>Event Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($events as $event)
                        <tr>
                          <td class="fw-semibold">{{ $loop->iteration }}</td>
                          <td>
                            @if ($event->event_image)
                              <img src="{{ asset('storage/' . $event->event_image) }}" width="80" height="50"
                                class="rounded object-fit-cover" alt="{{ $event->event_name }}">
                            @else
                              <img src="{{ asset('images/event-banner.jpg') }}" width="100" height="60"
                                class="rounded object-fit-cover" alt="No Image">
                            @endif
                          </td>
                          <td>{{ $event->event_name }}</td>
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
                            {{ $event->capacity }}
                        </td>

                        <td>
                            {{ $event->participants_count }}
                        </td>

                        <td>
                            {{ $event->capacity - $event->participants_count }}
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
                              <a class="btn btn-outline-info btn-sm" href="{{ route('events.show', $event->id) }}"
                                title="View Details">
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