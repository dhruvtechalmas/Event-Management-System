@extends('backend.layout.main')

@section('content')
  {{-- Add-event model form --}}
  <div class="modal fade" id="rolesUserModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
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
  {{-- // Main content area --}}
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

        @can('role.create')
          <button class="btn btn-outline-primary btn-sm d-flex justify-content-end" data-bs-toggle="modal"
            data-bs-target="#rolesUserModal">
            <i class="bi bi-person-plus" aria-hidden="true"></i> Add Role
          </button>
        @endcan
      </div>

      <section class="panel">
        <div class="panel-header"><input class="form-control form-control-sm table-search" type="search"
            placeholder="Search Roles" data-table-search="rolesTable" aria-label="Search roles">
        </div>

        <div class="table-responsive ">
          <table class="table align-middle mb-0" id="rolesTable" data-searchable-table>
            <thead>
              <tr>
                <th>#</th>
                <th>Role Name</th>
                <th>Permissions Name</th>
                <th>Created</th>
                <th class="text-right">Action</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              @foreach ($roles as $role)
                <tr>
                  <td class="fw-semibold">{{ $role->id }}</td>
                  <td>{{ $role->name }}</td>
                  <td>
                    @forelse($role->permissions as $permission)
                      <span class="badge bg-info me-1">
                        {{ $permission->name }}
                      </span>
                    @empty
                      <span class="badge bg-secondary">
                        No Permission
                      </span>
                    @endforelse
                  </td>
                  <td style="white-space: nowrap;">{{ $role->created_at->format('d-m-Y') }} </td>
                  <td style="white-space: nowrap;">
                    @can('role.edit')
                      <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal"
                        data-bs-target="#editRoleModal{{ $role->id }}" title="Edit Role">
                        <i class="bi bi-pencil-square" aria-hidden="true"></i>
                      </button>
                    @endcan

                    @can('role.delete')
                      <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm"
                          onclick="return confirm('Are you sure you want to delete this role?')" title="Delete Role">
                          <i class="bi bi-trash" aria-hidden="true"></i>
                        </button>
                      </form>
                    @endcan
                  </td>

                </tr>
                @include('backend.roles.edit', ['role' => $role])
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


@endsection