@extends('backend.layout.main')

@section('content')
  {{-- Add-event model form --}}
  <div class="modal fade" id="permissionsUserModal" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title btn btn-outline-dark">Add Permission</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          @include('backend.permissions.create')
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
            <h1 class="h3 mb-1">Permissions</h1>
          </div>
        </div>

        @can('permission.create')
          <button class="btn btn-outline-primary btn-sm d-flex justify-content-end" data-bs-toggle="modal"
            data-bs-target="#permissionsUserModal">
            <i class="bi bi-person-plus" aria-hidden="true"></i> Add Permission
          </button>
        @endcan
      </div>



      <section class="panel">
        <div class="panel-header"><input class="form-control form-control-sm table-search" type="search"
            placeholder="Search Permissions" data-table-search="permissionsTable" aria-label="Search permissions">
        </div>

        <div class="table-responsive ">
          <table class="table align-middle mb-0" id="permissionsTable" data-searchable-table>
            <thead>
              <tr>
                <th class="text-dark">#</th>
                <th class="text-dark">Permission Name</th>
                <th class="text-dark">Created</th>
                <th class="text-dark text-right">Action</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              @foreach ($permissions as $permission)
                <tr>
                  <td class="fw-semibold">{{ $permission->id }}</td>
                  <td>{{ $permission->name }}</td>
                  <td>{{ $permission->created_at->format('d-m-Y') }} </td>
                  <td style="white-space: nowrap;">
                    @can('permission.edit')
                      <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal"
                        data-bs-target="#editPermissionModal{{ $permission->id }}" title="Edit Permission">
                        <i class="bi bi-pencil-square" aria-hidden="true"></i>
                      </button>
                    @endcan

                    @can('permission.delete')
                      <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST"
                        style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm"
                          onclick="return confirm('Are you sure you want to delete this permission?')"
                          title="Delete Permission">
                          <i class="bi bi-trash" aria-hidden="true"></i>
                        </button>
                      </form>
                    @endcan
                  </td>

                </tr>
                @include('backend.permissions.edit', ['permission' => $permission])
              @endforeach
            </tbody>
          </table>
        </div>


        <div class="d-flex justify-content-end mt-3">
          {{ $permissions->links('pagination::bootstrap-4') }}
        </div>
      </section>
    </div>
  </main>


@endsection