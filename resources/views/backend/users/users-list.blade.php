@extends('backend.layout.main')

@section('content')

  {{-- // Main content area --}}
  <main class="dashboard-content">

    {{-- Add-user model form --}}
    <div class="modal fade" id="addUserModal" tabindex="-1">
      <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title btn btn-outline-dark">Add User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <div class="modal-body">
            @include('backend.users.add-user')
            @include('backend.users.edit') 
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
            <p class="text-muted mb-0">Review accounts, roles, account status, and team ownership.</p>
          </div>
        </div>
        <div class="heading-actions"><a class="btn btn-outline-secondary btn-sm" href="tables"><i class="bi bi-download"
              aria-hidden="true"></i> Export</a>

          <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="bi bi-person-plus" aria-hidden="true"></i> Add User
          </button>

        </div>
      </div>

      <section class="row g-3 mt-1" aria-label="User summary">
        <div class="col-12 col-sm-6 col-xl-3">
          <article class="metric-card metric-primary">
            <div class="metric-top">
              <span class="metric-label">Total Users</span>
              <span class="metric-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
            </div>
            <div class="metric-value">8,742</div>
            <div class="metric-meta">
              <span class="text-success">+5.1%</span>
              <span>this month</span>
            </div>
          </article>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
          <article class="metric-card metric-success">
            <div class="metric-top">
              <span class="metric-label">Active</span>
              <span class="metric-icon"><i class="bi bi-check2-circle" aria-hidden="true"></i></span>
            </div>
            <div class="metric-value">7,980</div>
            <div class="metric-meta">
              <span class="text-success">91%</span>
              <span>healthy accounts</span>
            </div>
          </article>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
          <article class="metric-card metric-warning">
            <div class="metric-top">
              <span class="metric-label">Pending</span>
              <span class="metric-icon"><i class="bi bi-hourglass-split" aria-hidden="true"></i></span>
            </div>
            <div class="metric-value">184</div>
            <div class="metric-meta">
              <span class="text-warning">12</span>
              <span>need approval</span>
            </div>
          </article>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
          <article class="metric-card metric-danger">
            <div class="metric-top">
              <span class="metric-label">Suspended</span>
              <span class="metric-icon"><i class="bi bi-slash-circle" aria-hidden="true"></i></span>
            </div>
            <div class="metric-value">38</div>
            <div class="metric-meta">
              <span class="text-danger">4</span>
              <span>flagged today</span>
            </div>
          </article>
        </div>
      </section>

      <section class="panel mt-3">
        <div class="panel-header">
          <div>
            <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i><span>User List</span></h2>
            <p class="text-muted mb-0">Search, review, and manage team member accounts.</p>
          </div>
          <div class="d-flex flex-wrap gap-2">
            <input class="form-control form-control-sm table-search" type="search" placeholder="Search users"
              data-table-search="usersTable" aria-label="Search users">

            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
              <i class="bi bi-person-plus" aria-hidden="true"></i> Add User
            </button>

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
                <th scope="col" class="text-dark">Action</th>
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
                    <td>{{ $user->role_id }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td class="text-dark">
                      <a class="btn btn-success btn-sm" href="{{ route('users.edit', $user->id) }}">Edit</a>
                     <a class="btn btn-danger btn-sm" href="#" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                    <a class="btn btn-light btn-sm" href="{{ route('users.show', $user->id) }}">View</a>
                    </td>
                  </tr>
                @endforeach
              @endif
            </tbody>
          </table>
        </div>


        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mt-3">
          <p class="text-muted small mb-0">Showing 1 to 5 of 124 users</p>
          <nav aria-label="Users pagination">
            <ul class="pagination pagination-sm mb-0">
              <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
              <li class="page-item active"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
          </nav>
        </div>
      </section>
    </div>
  </main>


@endsection