<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    {{-- CSS Style code --}}
    <style>
        body {
            background: #050510;
            color: white;
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
        }

        .hero {
            background:
                radial-gradient(circle at top,
                    rgba(124, 58, 237, 0.35),
                    transparent 45%),
                #050510;

            padding: 80px 0 60px;
        }

        .login-btn {
            background: #7c3aed;
            color: white;
            border: none;
            padding: 10px 30px;
            border-radius: 50px;
            font-weight: 600;
        }

        .login-btn:hover {
            background: #6d28d9;
            color: white;
        }

        .heading {
            text-align: center;
            margin-top: -55px;
        }

        .heading h1 {
            font-size: 50px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .heading p {
            color: #a1a1aa;
        }

        .events-section {
            padding-bottom: 80px;
        }

        .events-container {
            max-width: 900px;
            margin: auto;
            background: rgba(10, 10, 18, .95);
            border-radius: 15px;
            padding: 20px 35px;
        }

        .event-card {
            display: flex;
            align-items: center;
            gap: 25px;
            padding: 25px 0;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
            background: transparent;
            box-shadow: none;
            border-radius: 0;
            margin-bottom: 0;
        }

        .event-card:last-child {
            border-bottom: none;
        }

        .event-card:hover {
            transform: none;
            box-shadow: none;
        }



        .event-image {
            width: 220px;
            height: 130px;
            border-radius: 15px;
            overflow: hidden;
            flex-shrink: 0;
        }

        .event-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .event-body {
            flex: 1;
        }

        .event-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .event-meta {
            font-size: 13px;
            color: #9ca3af;
            margin-bottom: 5px;
        }

        .event-desc {
            font-size: 12px;
            color: #71717a;
        }

        .register-box {
            text-align: right;
            min-width: 130px;
        }

        .status {
            display: inline-block;
            background: rgba(124, 58, 237, .20);
            color: #c4b5fd;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            margin-bottom: 15px;
        }

        .register-btn {
            background: #7c3aed;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 9px 22px;
            font-size: 12px;
            font-weight: 600;
        }

        .register-btn:hover {
            background: #6d28d9;
            color: white;
        }

        .participant-modal {
            background: #11111b;
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 25px;
            color: white;
        }

        .participant-modal .modal-title {
            font-weight: 700;
        }

        .participant-modal .form-label {
            color: #d4d4d8;
            margin-bottom: 8px;
        }

        .participant-modal .form-control {
            background: #18181f;
            border: 1px solid #27272a;
            color: white;
            border-radius: 15px;
            padding: 14px 18px;
        }

        .participant-modal .form-control:focus {
            background: #18181f;
            color: white;
            border-color: #8b5cf6;
            box-shadow: 0 0 0 .25rem rgba(139, 92, 246, .20);
        }

        .btn-register {
            background: #8b5cf6;
            color: white;
            border-radius: 50px;
            padding: 14px;
            font-weight: 600;
            border: none;
        }

        .btn-register:hover {
            background: #7c3aed;
            color: white;
        }


        .event-modal {
            background: #11111b;
            color: white;
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 20px;
        }

        .event-modal .modal-title {
            font-weight: 600;
        }

        .event-modal .modal-body {
            padding: 30px;
        }

        .swal2-container {
            z-index: 999999 !important;
        }

        @media (max-width: 768px) {

            .event-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .event-image {
                width: 100%;
                height: 220px;
            }

            .register-box {
                width: 100%;
                text-align: left;
                margin-top: 15px;
            }

            .events-container {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    <section class="hero">

        <div class="container">

            <div class="text-end">

                @auth
                    <a href="{{ url('/event-dashboard') }}" class="btn login-btn">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn login-btn">
                        <i class="fa-solid fa-right-to-bracket me-2"></i>
                        Login
                    </a>
                @endauth

            </div>

            <div class="heading">
                <h1>Events List</h1>
                <p>Join Amazing Events Around You</p>
            </div>

        </div>

    </section>


    {{-- Upcoming Events list --}}
    <section class="events-section">

        <div class="container">

            <div class="events-container">

                @forelse($events as $event)

                    <div class="event-card">

                        <div class="event-image">
                            <td>
                                @if ($event->event_image)
                                    <img src="{{ asset('storage/' . $event->event_image) }}" width="100" height="60"
                                        class="rounded object-fit-cover" alt="{{ $event->event_name }}">
                                @else
                                    <img src="{{ asset('images/event-banner.jpg') }}" width="100" height="60"
                                        class="rounded object-fit-cover" alt="No Image">
                                @endif
                            </td>
                        </div>

                        <div class="event-body">

                            <h5 class="event-title">
                                {{ $event->event_name }}
                            </h5>

                            <div class="event-meta">
                                <i class="fa-solid fa-calendar-days me-2"></i>
                                {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                            </div>

                            <div class="event-meta">
                                <i class="fa-solid fa-location-dot me-2"></i>
                                {{ $event->event_location }}
                            </div>

                            <div class="mt-3">
                                <button type="button" class="btn btn-outline-light btn-sm viewEventBtn"
                                    data-name="{{ $event->event_name }}"
                                    data-date="{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}"
                                    data-time="{{ \Carbon\Carbon::parse($event->event_time)->format('h:i A') }}"
                                    data-location="{{ $event->event_location }}" data-status="{{ $event->status }}"
                                    data-description="{{ $event->description }}">
                                    <i class="fa-solid fa-eye me-1"></i>
                                    View Details
                                </button>
                            </div>
                        </div>

                        <div class="register-box">

                            <span class="status">
                                {{ $event->status == 'Upcoming' ? 'Upcoming' : '' }}
                            </span>

                            <br>

                            @if($event->participants_count >= $event->capacity)

                                <button class="btn btn-danger" disabled>
                                    Sold Out
                                </button>

                            @else

                                <button class="btn register-btn registerBtn" data-id="{{ $event->id }}"
                                    data-name="{{ $event->event_name }}" data-capacity="{{ $event->capacity }}"
                                    data-registered="{{ $event->participants_count }}">
                                    Register
                                </button>

                            @endif

                        </div>

                    </div>

                @empty

                    <div class="text-center text-secondary py-5">
                        No Events Available
                    </div>

                @endforelse

            </div>

        </div>

    </section>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Participants register form --}}
    <div class="modal fade" id="participantsUserModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content participant-modal">

                <div class="modal-header border-0">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-user-plus me-2"></i>
                        Register For Event
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    {{-- CRUCIAL: Display validation errors inside the modal --}}
                    @if ($errors->any())
                        <div class="alert alert-danger py-2 mb-3">
                            <ul class="mb-0 sm-text" style="padding-left: 20px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <h6 id="modalEventName"></h6>

                    <div class="event-meta">
                        Registered:
                        <span id="registeredCount">0</span>

                        <br>

                        Remaining:
                        <span id="remainingCount">0</span>
                    </div>

                    <div id="soldOutSection" class="mt-3"></div>

                    <form action="{{ route('participants.eventRegister') }}" method="POST" class="needs-validation"
                        novalidate>
                        @csrf

                        {{-- CRUCIAL: Added value="{{ old('event_id') }}" so the event context isn't lost on validation
                        failure --}}
                        <input type="hidden" name="event_id" id="modal_event_id">

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="full_name" value="{{ old('full_name') }}"
                                class="form-control form-control-sm" placeholder="Enter Full Name" required>
                            <div class="invalid-feedback">Participant name is required.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="form-control form-control-sm" placeholder="Enter Email" required>
                            <div class="invalid-feedback">Enter a valid email.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" maxlength="10"
                                oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                                class="form-control form-control-sm" placeholder="Enter Phone Number" required>
                            <div class="invalid-feedback">Phone number is required.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" value="{{ old('address') }}"
                                class="form-control form-control-sm text-light" placeholder="Enter Address" required>
                            <div class="invalid-feedback">Address is required.</div>
                        </div>

                        <button class="btn btn-register w-100">
                            <i class="fa-solid fa-user-check me-2"></i>
                            Register Now
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>




    {{-- Event Model Details --}}
    <div class="modal fade" id="eventDetailModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content event-modal">

                <div class="modal-header border-0">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-calendar-days me-2"></i>
                        Event Details
                    </h5>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body">

                    <h3 id="detailName" class="fw-bold mb-4"></h3>

                    <div class="mb-3">
                        <i class="fa-solid fa-calendar-days text-primary me-2"></i>
                        <strong>Date:</strong>
                        <span id="detailDate"></span>
                    </div>

                    <div class="mb-3">
                        <i class="fa-solid fa-clock text-warning me-2"></i>
                        <strong>Time:</strong>
                        <span id="detailTime"></span>
                    </div>

                    <div class="mb-3">
                        <i class="fa-solid fa-location-dot text-danger me-2"></i>
                        <strong>Location:</strong>
                        <span id="detailLocation"></span>
                    </div>

                    <div class="mb-3">
                        <i class="fa-solid fa-circle-info text-success me-2"></i>
                        <strong>Status:</strong>
                        <span id="detailStatus"></span>
                    </div>

                    <hr>

                    <h6 class="mb-3">Description</h6>

                    <p id="detailDescription" class="text-secondary mb-0"></p>

                </div>

            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).on('click', '.registerBtn', function () {

            let eventId = $(this).data('id');
            let eventName = $(this).data('name');
            let capacity = parseInt($(this).data('capacity')) || 0;
            let registered = parseInt($(this).data('registered')) || 0;
            let remaining = Math.max(capacity - registered, 0);

            // Target modal form
            let $form = $('#participantsUserModal').find('form');

            // Clear previous form values
            $form.find('input[name="full_name"]').val('');
            $form.find('input[name="email"]').val('');
            $form.find('input[name="phone"]').val('');
            $form.find('input[name="address"]').val('');

            // Set hidden event id
            $('#modal_event_id').val(eventId);

            // Set event information
            $('#modalEventName').text(eventName);
            $('#registeredCount').text(registered);
            $('#remainingCount').text(remaining);

            // Remove previous validation errors
            $('#participantsUserModal').find('.alert-danger').remove();
            $form.removeClass('was-validated');

            // Show Sold Out button
            if (registered >= capacity) {
                $('#soldOutSection').html(`
                <button type="button"
                        class="btn btn-danger w-100"
                        disabled>
                    Sold Out
                </button>`);
            } else {
                $('#soldOutSection').html('');
            }

            // Open modal
            $('#participantsUserModal').modal('show');
        });
    </script>

    <script>
        (() => {
            'use strict';

            const forms = document.querySelectorAll('.needs-validation');

            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }

                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>

    <script>
        $('.viewEventBtn').click(function () {

            $('#detailName').text($(this).data('name'));
            $('#detailDate').text($(this).data('date'));
            $('#detailTime').text($(this).data('time'));
            $('#detailLocation').text($(this).data('location'));
            $('#detailStatus').text($(this).data('status'));
            $('#detailDescription').text($(this).data('description'));

            $('#eventDetailModal').modal('show');
        });
    </script>


    @if(session()->has('message'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: "{{ session('alert-type', 'success') }}",
                    title: "{{ session('message') }}",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Targets your registration modal wrapper element
                var registrationModalEl = document.getElementById('participantsUserModal');

                if (registrationModalEl) {
                    var registrationModal = new bootstrap.Modal(registrationModalEl);
                    registrationModal.show();
                }
            });
        </script>
    @endif


</body>

</html>