@extends('backend.layout.main')

@section('content')

  @php
    $color = '#' . substr(md5($user->email), 0, 6);
  @endphp

  <main class="dashboard-content">

    <div class="container-fluid px-3 px-lg-4 py-4">

      <div class="page-heading">
        <div class="page-heading-copy">
          <span class="page-icon">
            <i class="bi bi-person-lines-fill"></i>
          </span>

          <div>
            <p class="eyebrow mb-1">Management</p>
            <h1 class="h3 mb-1">User Details</h1>
            <p class="text-muted mb-0">
              Inspect account status, profile data, permissions, and recent activity.
            </p>
          </div>
        </div>

        <div class="heading-actions">

          <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i>
            Back to Users
          </a>

        </div>
      </div>

      <section class="row g-3">

        <!-- Left Card -->
        <div class="col-12 col-xl-4">

          <div class="panel h-100 text-center profile-card">

            <div class="profile-cover"></div>

            <div class="profile-hero">

              <div class="profile-avatar" style="background-color: {{ $color }}">
                {{ strtoupper(substr($user->email, 0, 1)) }}
              </div>

              <h2 class="h5 mt-3 mb-1">
                {{ $user->name }}
              </h2>

              <p class="text-muted mb-3">
                {{ $user->role_id == 1 ? 'Super Admin' : ($user->role_id == 2 ? 'Event Manager' : 'Staff') }}
              </p>

              <span class="badge text-bg-success">
                Active Account
              </span>

            </div>

            <div class="info-list mt-4 text-start">

              <div>
                <span>Name</span>
                <strong>{{ $user->name }}</strong>
              </div>

              <div>
                <span>Email</span>
                <strong>{{ $user->email }}</strong>
              </div>

              <div>
                <span>Phone</span>
                <strong>{{ $user->phone ?? 'N/A' }}</strong>
              </div>

              <div>
                <span>Role</span>
                <strong>
                  {{ $user->role_id == 1 ? 'Super Admin' : ($user->role_id == 2 ? 'Event Manager' : 'Staff') }}
                </strong>
              </div>

              <div>
                <span>Joined</span>
                <strong>
                  {{ $user->created_at->format('d M Y') }}
                </strong>
              </div>

            </div>

          </div>

        </div>

        <!-- Right Side -->
        <div class="col-12 col-xl-8">

          <div class="panel mb-3">

            <div class="panel-header">

              <div>
                <h2 class="h5 mb-1 section-title">
                  <i class="bi bi-person-lines-fill"></i>
                  <span>Account Overview</span>
                </h2>

                <p class="text-muted mb-0">
                  Permissions, plan, and current access details.
                </p>
              </div>

              {{-- <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">
                <i class="bi bi-pencil-square"></i> Edit
              </a> --}}

            </div>

            <div class="row g-3">

              <div class="col-md-4">
                <div class="mini-card">
                  <span>Role</span>
                  <strong>
                    {{ $user->role_id == 1 ? 'Super Admin' : ($user->role_id == 2 ? 'Event Manager' : 'Staff') }}
                  </strong>
                </div>
              </div>

              <div class="col-md-4">
                <div class="mini-card">
                  <span>User ID</span>
                  <strong>#{{ $user->id }}</strong>
                </div>
              </div>

              <div class="col-md-4">
                <div class="mini-card">
                  <span>Created</span>
                  <strong>
                    {{ $user->created_at->format('d M Y') }}
                  </strong>
                </div>
              </div>

            </div>

          </div>

          <div class="panel">

            <div class="panel-header">
              <div>
                <h2 class="h5 mb-1 section-title">
                  <i class="bi bi-clock-history"></i>
                  <span>Recent Activity</span>
                </h2>

                <p class="text-muted mb-0">
                  Latest security and workflow events.
                </p>
              </div>
            </div>

            <div class="activity-list">

              <div class="activity-item">
                <span class="activity-dot bg-primary"></span>

                <div>
                  <p class="mb-1 fw-semibold">
                    User account created
                  </p>

                  <p class="text-muted small mb-0">
                    {{ $user->created_at->diffForHumans() }}
                  </p>
                </div>
              </div>

              <div class="activity-item"> 
                <span class="activity-dot bg-success"></span>

                <div>
                  <p class="mb-1 fw-semibold">
                    Role assigned:
                    {{ $user->role_id == 1 ? 'Super Admin' : ($user->role_id == 2 ? 'Event Manager' : 'Staff') }}
                  </p>

                  <p class="text-muted small mb-0">
                    Active user
                  </p>
                </div>
              </div>

            </div>

          </div>

        </div>

      </section>

    </div>

  </main>

  <style>
    .profile-avatar {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      color: white;
      font-size: 38px;
      font-weight: 700;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: auto;
      border: 4px solid #fff;
      box-shadow: 0 4px 15px rgba(0, 0, 0, .15);
    }
  </style>

@endsection