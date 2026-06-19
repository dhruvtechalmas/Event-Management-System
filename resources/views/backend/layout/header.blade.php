<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="adminHMD professional admin dashboard template">
  <title>Dashboard | Event Management</title>

  <link rel="stylesheet" href="{{ url('/backend/assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ url('/backend/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
  <link rel="stylesheet" href="{{ url('/backend/assets/css/style.css') }}">
  @vite(['resources/js/app.js'])
</head>

<body>
  <div class="admin-shell">
    <div class="sidebar-backdrop" data-sidebar-close></div>

    <aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">
      <div class="sidebar-header">
        <a class="brand-mark" href="{{route('backend.index')}}" aria-label="adminHMD dashboard">
          <span class="brand-icon"><i class="bi bi-grid-1x2-fill" aria-hidden="true"></i></span>
          <span class="brand-copy">
            <span class="brand-title">Event Management</span>
            <span class="brand-subtitle">Dashboard</span>
          </span>
        </a>
      </div>
      {{-- @dd(auth()->user()->getRoleNames()) --}}
      <nav class="sidebar-nav">
        <a class="nav-link active" href="{{route('backend.index')}}" aria-current="page">
          <span class="nav-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
          <span class="nav-text">Dashboard</span>
        </a>
        @can('event.index')
          <a class="nav-link active " href="{{route('events.index')}}">
            <span class="nav-icon"><i class="bi bi-calendar2-event-fill" aria-hidden="true"></i></span>
            <span class="nav-text">Events</span>
          </a>
        @endcan

        @can('participant.index')
          <a class="nav-link active " href="{{route('participants.index')}}">
            <span class="nav-icon"><i class="bi bi-people-fill" aria-hidden="true"></i></span>
            <span class="nav-text">Participants</span>
          </a>
        @endcan

        @can('task.index')
          <a class="nav-link active " href="{{route('tasks.index')}}">
            <span class="nav-icon"><i class="bi bi-list-task" aria-hidden="true"></i></span>
            <span class="nav-text">Tasks</span>
          </a>
        @endcan

        @can('role.index')
          <a class="nav-link active " href="roles">
            <span class="nav-icon"><i class="bi bi-person-fill-gear" aria-hidden="true"></i></span>
            <span class="nav-text">Roles</span>
          </a>
        @endcan

        @can('permission.index')
          <a class="nav-link active " href="{{route('permissions.index')}}">
            <span class="nav-icon"><i class="bi bi-list-columns" aria-hidden="true"></i></span>
            <span class="nav-text">Permissions</span>
          </a>
        @endcan

        @can('user.index')
          <a class="nav-link active" href="{{route('users.index')}}">
            <span class="nav-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
            <span class="nav-text">Users</span>
          </a>
        @endcan

        <a class="nav-link active" href="{{route('calendar.calendarindex')}}">
          <span class="nav-icon"><i class="bi bi-calendar" aria-hidden="true"></i></span>
          <span class="nav-text">Calendar</span>
        </a>

        <a class="nav-link active" href="{{ route('recycle-bin.index') }}">
          <span class="nav-icon"><i class="bi bi-trash" aria-hidden="true"></i></span>
          <span class="nav-text">Recycle Bin</span>
        </a>

        <a class="nav-link active" href="settings">
          <span class="nav-icon"><i class="bi bi-gear" aria-hidden="true"></i></span>
          <span class="nav-text">Settings</span>
        </a>
      </nav>


      {{-- <div class="sidebar-user">
        <img class="avatar-img avatar-md sidebar-user-avatar"
          src="{{ url('/backend/assets/images/avatar/avatar-2.jpg') }}" alt="Admin Hasan">
        <strong>Super Admin</strong>
        <small>Active Workspace</small>
      </div>
      <div class="sidebar-footer">
        <span class="status-dot"></span>
        <span class="sidebar-footer-text">System running smoothly</span>
      </div> --}}

    </aside>

    <div class="admin-main">
      <nav class="navbar admin-navbar navbar-expand bg-white">
        <div class="container-fluid px-3 px-lg-4">
          <button class="sidebar-toggle" type="button" data-sidebar-toggle aria-controls="adminSidebar"
            aria-expanded="true" aria-label="Toggle sidebar">
            <span></span>
            <span></span>
            <span></span>
          </button>

          {{-- <form class="d-none d-md-flex ms-3 flex-grow-1" role="search">
            <input class="form-control search-input" type="search" placeholder="Search users, orders, reports"
              aria-label="Search">
          </form> --}}

          <div class="navbar-actions ms-auto">
            <button class="icon-button theme-toggle" type="button" data-theme-toggle aria-label="Switch color theme"
              title="Switch color theme">
              <i class="bi bi-moon-stars" data-theme-icon aria-hidden="true"></i>
            </button>

            {{-- Notification dropdown --}}
            <div class="dropdown">
              <button class="icon-button position-relative" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <span id="notif-badge"
                  class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger {{ auth()->user()->unreadNotifications->count() == 0 ? 'd-none' : '' }}">
                  {{ auth()->user()->unreadNotifications->count() }}
                </span>
                <i class="bi bi-bell"></i>
              </button>

              <div class="dropdown-menu dropdown-menu-end" style="min-width:320px;">

                <div class="dropdown-header d-flex justify-content-between align-items-center border-bottom pb-2">

                  <span id="notif-header-text">
                    Notifications ({{ auth()->user()->unreadNotifications->count() }} Unread)
                  </span>
                  <a href="javascript:void(0);" id="mark-all-read-btn"
                    class="btn btn-sm btn-link text-decoration-none p-0 text-primary">
                    Mark all read
                  </a>
                </div>

                <div id="notification-list-container">

                  @forelse(auth()->user()->unreadNotifications as $notification)
                    <a class="dropdown-item d-flex flex-column py-2 border-bottom notification-item"
                      href="{{ route('notifications.markRead', $notification->id) }}">
                      <span class="fw-bold">
                        {{ $notification->data['title'] }}
                      </span>
                      <small>
                        {{ $notification->data['message'] }}
                      </small>
                      <span class="text-muted small">
                        {{ $notification->created_at->diffForHumans() }}
                      </span>
                    </a>
                  @empty
                    <div id="no-notif-msg" class="text-center py-4 text-muted">
                      No new unread notifications
                    </div>
                  @endforelse

                </div>

                <div class="text-center pt-2">
                  <a href="{{ route('notifications.history') }}" class="dropdown-item text-primary fw-bold text-center">
                    View All History Log
                  </a>
                </div>

              </div>
            </div>

            <div class="dropdown">
              <button class="profile-button dropdown-toggle" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <img class="avatar-img avatar-sm" src="{{ url('/backend/assets/images/avatar/avatar-2.jpg') }}"
                  alt="Super Admin">
                <span class="profile-name d-none d-sm-inline">
                  {{ auth()->user()->name }}
                  <br>
                  {{ auth()->user()->getRoleNames()->first() }}
                </span>
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="profile">Profile</a></li>
                <a class="dropdown-item" href="{{ route('google.login') }}">
                  <i class="bi bi-google"></i>
                  Connect Google Calendar
                </a>
                <li><a class="dropdown-item" href="settings">Account settings</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="logout">Sign out</a></li>
              </ul>
            </div>
          </div>
        </div>
      </nav>