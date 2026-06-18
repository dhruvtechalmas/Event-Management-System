@extends('backend.layout.main')

@section('content')

  {{-- // Main content area --}}
  <main class="dashboard-content">

    {{-- Add-user model form --}}
    <div class="modal fade" id="addUserModal" tabindex="-1">
      <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title btn btn-outline-secondary">Add User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <div class="modal-body">
            @include('backend.users.add-user')
          </div>
        </div>
      </div>
    </div>

    {{-- All content below is for the main users page --}}
    <div class="container-fluid px-3 px-lg-4 py-4">
      <div class="page-heading">
        <div class="page-heading-copy">
          <span class="page-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
          <div>
            <p class="eyebrow mb-1">Management</p>
            <h1 class="h3 mb-1">Users</h1>
          </div>
        </div>
        <div class="heading-actions"><a class="btn btn-outline-secondary btn-sm" href="tables"><i class="bi bi-download"
              aria-hidden="true"></i> Export</a>

          @can('user.create')
            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
              <i class="bi bi-person-plus" aria-hidden="true"></i> Add User
            </button>
          @endcan

        </div>
      </div>

      <!-- 📊 TOP ROLE SUMMARY METRIC CARDS SECTION -->
      {{-- <section class="row g-3 mb-4" aria-label="User role summary">
        <!-- Card 1: Total Global Users Roster -->
        <div class="col-12 col-sm-6 col-xl-3">
          <article class="metric-card metric-primary">
            <div class="metric-top">
              <span class="metric-label">Total Users</span>
              <span class="metric-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
            </div>
            <div class="metric-value">{{ number_format($totalUsers ?? 0) }}</div>
            <div class="metric-meta">
              <span class="text-primary">Master</span>
              <span>system directory</span>
            </div>
          </article>
        </div>

        <!-- Card 2: Super Admin Access Pool -->
        <div class="col-12 col-sm-6 col-xl-3">
          <article class="metric-card metric-danger">
            <div class="metric-top">
              <span class="metric-label">Super Admins</span>
              <span class="metric-icon"><i class="bi bi-shield-lock" aria-hidden="true"></i></span>
            </div>
            <div class="metric-value">{{ number_format($superAdminsCount ?? 0) }}</div>
            <div class="metric-meta">
              <span class="text-danger">Root</span>
              <span>access controls</span>
            </div>
          </article>
        </div>

        <!-- Card 3: Event Manager Operational Group -->
        <div class="col-12 col-sm-6 col-xl-3">
          <article class="metric-card metric-warning">
            <div class="metric-top">
              <span class="metric-label">Event Managers</span>
              <span class="metric-icon"><i class="bi bi-calendar-event" aria-hidden="true"></i></span>
            </div>
            <div class="metric-value">{{ number_format($eventManagersCount ?? 0) }}</div>
            <div class="metric-meta">
              <span class="text-warning">Operations</span>
              <span>coordinators</span>
            </div>
          </article>
        </div>

        <!-- Card 4: Frontline Staff Team Count -->
        <div class="col-12 col-sm-6 col-xl-3">
          <article class="metric-card metric-success">
            <div class="metric-top">
              <span class="metric-label">Staff Members</span>
              <span class="metric-icon"><i class="bi bi-person-workspace" aria-hidden="true"></i></span>
            </div>
            <div class="metric-value">{{ number_format($staffCount ?? 0) }}</div>
            <div class="metric-meta">
              <span class="text-success">Execution</span>
              <span>operators roster</span>
            </div>
          </article>
        </div>
      </section> --}}


      <section class="panel mt-3">
        <div class="panel-header">
          {{-- <div>
            <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i><span>User List</span></h2>
          </div> --}}
          <div class="d-flex flex-wrap gap-2">
            <input class="form-control form-control-sm table-search" type="search" placeholder="Search users"
              data-table-search="usersTable" aria-label="Search users">
          </div>
        </div>

        <div class="table-responsive">
          <table class="table align-middle mb-0" id="usersTable" data-searchable-table>
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">User Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Role</th>
                <th scope="col">Joined</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @if ($users->IsNotEmpty())
                @foreach ($users as $user)

                  @php
                    $colors = [
                      '#ef4444',
                      '#3b82f6',
                      '#10b981',
                      '#f59e0b',
                      '#8b5cf6',
                      '#ec4899',
                      '#14b8a6',
                      '#f97316',
                    ];

                    $color = $colors[ord(strtoupper(substr($user->email, 0, 1))) % count($colors)];
                  @endphp

                  <tr>
                    <td>{{ $user->id }}</td>
                    <td>
                      <div class="d-flex align-items-center gap-2">

                        <div class="avatar-circle" style="background-color: {{ $color }}">
                          {{ strtoupper(substr($user->email, 0, 1)) }}
                        </div>

                        <span class="fw-semibold">
                          {{ $user->name }}
                        </span>

                      </div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->role_id == 1 ? 'Super Admin' : ($user->role_id == 2 ? 'Event Manager' : 'Staff') }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td style="white-space: nowrap;">
                      @can('user.edit')
                        <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal"
                          data-bs-target="#editUserModal{{ $user->id }}" title="Edit User">
                          <i class="bi bi-pencil-square" aria-hidden="true"></i>
                        </button>
                      @endcan

                      @can('user.delete')
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-outline-danger btn-sm"
                            onclick="return confirm('Are you sure you want to delete this user?')" title="Delete User">
                            <i class="bi bi-trash" aria-hidden="true"></i>
                          </button>
                        </form>
                      @endcan

                      @can('user.view')
                        <a class="btn btn-outline-info btn-sm" href="{{ route('users.show', $user->id) }}" title="View User">
                          <i class="bi bi-eye" aria-hidden="true"></i>
                        </a>
                      @endcan
                    </td>

                  </tr>

                  @include('backend.users.edit', ['user' => $user, 'roles' => $roles])
                @endforeach
              @endif
            </tbody>
          </table>
        </div>

        {{-- Pagination controls --}}
        <div class="d-flex justify-content-end mt-3">
          {{ $users->links('pagination::bootstrap-4') }}
        </div>

        {{-- <div class="d-flex justify-content-end gap-2 mt-4">

          @if ($users->onFirstPage())
          <button class="btn btn-outline-secondary" disabled>
            ← Previous
          </button>
          @else
          <a href="{{ $users->previousPageUrl() }}" class="btn btn-outline-primary">
            ← Previous
          </a>
          @endif
          @if ($users->hasMorePages())
          <a href="{{ $users->nextPageUrl() }}" class="btn btn-outline-primary">
            Next →
          </a>
          @else
          <button class="btn btn-outline-secondary" disabled>
            Next →
          </button>
          @endif

        </div> --}}

      </section>
    </div>


  </main>


@endsection