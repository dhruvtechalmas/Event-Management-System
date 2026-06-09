@extends('backend.layout.main')

@section('content')
  {{-- Add-event model form --}}
  <div class="modal fade" id="participantsUserModal" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title btn btn-outline-dark">Add Participant</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          @include('backend.participants.create')
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
            <h1 class="h3 mb-1">Participants</h1>
          </div>
        </div>

        <button class="btn btn-primary btn-sm d-flex justify-content-end" data-bs-toggle="modal"
          data-bs-target="#participantsUserModal">
          <i class="bi bi-person-plus" aria-hidden="true"></i> Add Participant
        </button>
      </div>



      <section class="panel">
        <div class="panel-header"><input class="form-control form-control-sm table-search" type="search"
            placeholder="Search participants" data-table-search="participantsTable" aria-label="Search participants">
        </div>

        <div class="table-responsive ">
          <table class="table align-middle mb-0" id="participantsTable" data-searchable-table>
            <thead>
              <tr>
                <th class="text-dark">#</th>
                <th class="text-dark">Participant Name</th>
                <th class="text-dark">Email</th>
                <th class="text-dark">Event Name</th>
                <th class="text-dark">Phone</th>
                <th class="text-dark text-right">Action</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              @foreach ($participants as $participant)
                <tr>
                  <td class="fw-semibold">{{ $participant->id }}</td>
                  <td>{{ $participant->full_name }}</td>
                  <td>{{ $participant->email }}</td>
                  <td>{{ $participant->event->event_name ?? 'No Event Selected' }}</td>
                  <td>{{ $participant->phone }}</td>
                  <td>
                    <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                      data-bs-target="#editParticipantModal{{ $participant->id }}">
                      Edit
                    </button>

                    <form action="{{ route('participants.destroy', $participant->id) }}" method="POST" style="display: inline;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm"
                        onclick="return confirm('Are you sure you want to delete this participant?')">
                        Delete
                      </button>
                    </form>

                      <a class="btn btn-light btn-sm" href="{{ route('participants.show',$participant->id) }}">View</a>
                  </td>
                </tr>
                @include('backend.participants.edit', ['participant' => $participant])
              @endforeach
            </tbody>
          </table>
        </div>

        {{-- Pagination controls --}}
        <div class="d-flex justify-content-end mt-3">
          {{ $participants->links('pagination::bootstrap-4') }}
        </div>
      </section>
    </div>
  </main>


@endsection