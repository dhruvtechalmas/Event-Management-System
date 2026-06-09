{{-- @extends('backend.layout.main')

@section('content')
  Add-event model form
  <div class="modal fade" id="rolesUserModal" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title btn btn-outline-dark">Add Role</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          @include('backend.roles.create')
        </div>
      </div>
    </div>
  </div>
  // Main content area
  <main class="dashboard-content">
    <div class="container-fluid px-3 px-lg-4 py-4">
      <div class="page-heading">
        <div class="page-heading-copy">
          <span class="page-icon"><i class="bi bi-table" aria-hidden="true"></i></span>
          <div>
            <p class="eyebrow mb-1">Data</p>
            <h1 class="h3 mb-1">Roles</h1>
          </div>
        </div>

        <button class="btn btn-primary btn-sm d-flex justify-content-end" data-bs-toggle="modal"
          data-bs-target="#rolesUserModal">
          <i class="bi bi-person-plus" aria-hidden="true"></i> Add Role
        </button>
      </div>



      <section class="panel">
        <div class="panel-header"><input class="form-control form-control-sm table-search" type="search"
            placeholder="Search Roles" data-table-search="rolesTable" aria-label="Search roles">
        </div>

        <div class="table-responsive ">
          <table class="table align-middle mb-0" id="rolesTable" data-searchable-table>
            <thead>
              <tr>
                <th class="text-dark">#</th>
                <th class="text-dark">Role Name</th>
                <th class="text-dark text-right">Action</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              @foreach ($roles as $role)
                <tr>
                  <td class="fw-semibold">{{ $role->id }}</td>
                  <td>{{ $role->name }}</td>
                  <td>
                    <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                      data-bs-target="#editRoleModal{{ $role->id }}">
                      Edit
                    </button>

                    <form action="#" method="POST" style="display: inline;">
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

        
        <div class="d-flex justify-content-end mt-3">
          {{ $roles->links('pagination::bootstrap-4') }}
        </div>
      </section>
    </div>
  </main>


@endsection --}}