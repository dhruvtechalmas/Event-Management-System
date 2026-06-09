@extends('backend.layout.main')

@section('content')

@php
    $color = '#' . substr(md5($participant->email), 0, 6);
@endphp

<main class="dashboard-content">

    <div class="container-fluid px-3 px-lg-4 py-4">

        <div class="page-heading">
            <div class="page-heading-copy">
                <span class="page-icon">
                    <i class="bi bi-people"></i>
                </span>

                <div>
                    <p class="eyebrow mb-1">Management</p>
                    <h1 class="h3 mb-1">Participant Details</h1>
                </div>
            </div>

            <div class="heading-actions">
                <a href="{{ route('participants.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i>
                    Back to Participants
                </a>
            </div>
        </div>

        <section class="row g-3">

            <div class="col-12 col-xl-4">

                <div class="panel h-100 text-center profile-card">

                    <div class="profile-cover"></div>

                    <div class="profile-hero">

                        <div class="profile-avatar" style="background-color: {{ $color }}">
                            {{ strtoupper(substr($participant->full_name, 0, 1)) }}
                        </div>

                        <h2 class="h5 mt-3 mb-1">
                            {{ $participant->full_name }}
                        </h2>

                        <p class="text-muted">
                            {{ $participant->email }}
                        </p>

                    </div>

                    <div class="info-list mt-4 text-start">

                        <div>
                            <span>Name</span>
                            <strong>{{ $participant->full_name }}</strong>
                        </div>

                        <div>
                            <span>Email</span>
                            <strong>{{ $participant->email }}</strong>
                        </div>

                        <div>
                            <span>Phone</span>
                            <strong>{{ $participant->phone }}</strong>
                        </div>

                        <div>
                            <span>Event</span>
                            <strong>{{ $participant->event->event_name }}</strong>
                        </div>

                    </div>

                </div>

            </div>

            <div class="col-12 col-xl-8">

                <div class="panel mb-3">

                    <div class="panel-header">
                        <h2 class="h5 mb-0">Participant Overview</h2>
                    </div>

                    <div class="row g-3">

                        <div class="col-md-4">
                            <div class="mini-card">
                                <span>Participant ID</span>
                                <strong>#{{ $participant->id }}</strong>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mini-card">
                                <span>Event</span>
                                <strong>{{ $participant->event->event_name }}</strong>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mini-card">
                                <span>Joined</span>
                                <strong>{{ $participant->created_at->format('d M Y') }}</strong>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="panel mb-3">

                    <div class="panel-header">
                        <h2 class="h5 mb-0">Address</h2>
                    </div>

                    <p>{{ $participant->address ?? 'No address available.' }}</p>

                </div>

                <div class="panel">

                    <div class="panel-header">
                        <h2 class="h5 mb-0">Notes</h2>
                    </div>

                    <p>{{ $participant->notes ?? 'No notes available.' }}</p>

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
    box-shadow: 0 4px 15px rgba(0,0,0,.15);
}
</style>

@endsection