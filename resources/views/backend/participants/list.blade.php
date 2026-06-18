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

        @can('participant.create')
          <button class="btn btn-outline-primary btn-sm d-flex justify-content-end" data-bs-toggle="modal"
            data-bs-target="#participantsUserModal">
            <i class="bi bi-person-plus" aria-hidden="true"></i> Add Participant
          </button>
        @endcan

      </div>



      <section class="panel">
        <div class="panel-header"><input class="form-control form-control-sm table-search" type="search"
            placeholder="Search participants" data-table-search="participantsTable" aria-label="Search participants">
        </div>

        <div class="table-responsive ">
          <table class="table align-middle mb-0" id="participantsTable" data-searchable-table>
            <thead>
              <tr>
                <th>#</th>
                <th>Participant Name</th>
                <th>Email</th>
                <th>Event Name</th>
                <th>Phone</th>
                <th class="text-right">Action</th>
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
                  <td style="white-space: nowrap;">
                    @can('participant.edit')
                      <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal"
                        data-bs-target="#editParticipantModal{{ $participant->id }}" title="Edit Participant">
                        <i class="bi bi-pencil-square" aria-hidden="true"></i>
                      </button>
                    @endcan

                    @can('participant.delete')
                      <form action="{{ route('participants.destroy', $participant->id) }}" method="POST"
                        style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm"
                          onclick="return confirm('Are you sure you want to delete this participant?')"
                          title="Delete Participant">
                          <i class="bi bi-trash" aria-hidden="true"></i>
                        </button>
                      </form>
                    @endcan

                    @can('participant.view')
                      <a class="btn btn-outline-info btn-sm" href="{{ route('participants.show', $participant->id) }}"
                        title="View Participant">
                        <i class="bi bi-eye" aria-hidden="true"></i>
                      </a>
                    @endcan
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