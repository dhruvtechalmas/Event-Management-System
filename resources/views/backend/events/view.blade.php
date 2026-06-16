@extends('backend.layout.main')

@section('content')

    @php
        $color = '#' . substr(md5($event->event_name), 0, 6);
    @endphp

    <main class="dashboard-content">

        <div class="container-fluid px-3 px-lg-4 py-4">

            <div class="page-heading">
                <div class="page-heading-copy">
                    <span class="page-icon">
                        <i class="bi bi-calendar-event"></i>
                    </span>

                    <div>
                        <p class="eyebrow mb-1">Management</p>
                        <h1 class="h3 mb-1">Event Details</h1>
                        <p class="text-muted mb-0">
                            View complete event information and status.
                        </p>
                    </div>
                </div>

                <div class="heading-actions">
                    <a href="{{ route('events.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i>
                        Back to Events
                    </a>
                </div>


            </div>

            <section class="row g-3">

                <div class="col-12 col-xl-4">

                    <div class="panel h-100 text-center profile-card">

                        <div class="profile-cover"></div>

                        <div class="profile-hero">

                            <div class="profile-avatar" style="background-color: {{ $color }}">
                                {{ strtoupper(substr($event->event_name, 0, 1)) }}
                            </div>

                            <h2 class="h5 mt-3 mb-1">
                                {{ $event->event_name }}
                            </h2>

                            <p class="text-muted mb-3">
                                {{ $event->event_type }}
                            </p>

                            <span class="badge bg-primary">
                                {{ $event->status }}
                            </span>

                        </div>

                        <div class="info-list mt-4 text-start">

                            <div>
                                <span>Event Name</span>
                                <strong>{{ $event->event_name }}</strong>
                            </div>

                            <div>
                                <span>Type</span>
                                <strong>{{ $event->event_type }}</strong>
                            </div>

                            <div>
                                <span>Date</span>
                                <strong>{{ $event->event_date }}</strong>
                            </div>

                            <div>
                                <span>Time</span>
                                <strong>{{ $event->event_time }}</strong>
                            </div>

                            <div>
                                <span>Location</span>
                                <strong>{{ $event->event_location }}</strong>
                            </div>

                            <div>
                                <span>Status</span>
                                <strong>{{ $event->status }}</strong>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-12 col-xl-8">

                    <div class="panel mb-3">

                        <div class="panel-header">
                            <h2 class="h5 mb-0">Event Overview</h2>

                            <div class="heading-actions">
                                <!-- Single Event PDF Export Button -->
                                <a href="{{ route('events.pdf.single', $event->id) }}"
                                    class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-download" aria-hidden="true"></i> Export PDF
                                </a>
                            </div>
                        </div>

                        <div class="row g-3">

                            <div class="col-md-4">
                                <div class="mini-card">
                                    <span>Status</span>
                                    <strong>{{ $event->status }}</strong>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mini-card">
                                    <span>Event ID</span>
                                    <strong>#{{ $event->id }}</strong>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mini-card">
                                    <span>Date</span>
                                    <strong>{{ $event->event_date }}</strong>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="panel mb-3">

                        <div class="panel-header">
                            <h2 class="h5 mb-0">Description</h2>
                        </div>

                        <p>
                            {{ $event->description ?? 'No description available.' }}
                        </p>

                    </div>

                    <div class="panel">

                        <div class="panel-header">
                            <h2 class="h5 mb-0">Recent Activity</h2>
                        </div>

                        <div class="activity-item">
                            <span class="activity-dot bg-primary"></span>
                            <div>
                                <p class="mb-1 fw-semibold">Event Created</p>
                                <p class="text-muted small mb-0">
                                    {{ $event->created_at->diffForHumans() }}
                                </p>
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