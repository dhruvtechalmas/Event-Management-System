@extends('backend.layout.main')

@section('content')

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">

    <style>
        .calendar-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }

        #calendar {
            width: 100%;
        }

        /* Toolbar */
        .fc .fc-toolbar {
            margin-bottom: 20px !important;
        }

        .fc .fc-toolbar-title {
            font-size: 24px !important;
            font-weight: 700 !important;
            color: #212529;
        }

        /* Buttons */
        .fc .fc-button {
            background: #fff !important;
            border: 1px solid #dee2e6 !important;
            color: #495057 !important;
            padding: 8px 16px !important;
            margin: 0 4px !important;
            border-radius: 8px !important;
            font-weight: 600 !important;
        }

        .fc .fc-button:hover {
            background: #f8f9fa !important;
        }

        .fc .fc-button-active {
            background: #0d6efd !important;
            color: #fff !important;
            border-color: #0d6efd !important;
        }

        /* Day Header */
        .fc-col-header-cell {
            background: #f8f9fa;
            padding: 10px 0;
            font-weight: 700;
            font-size: 14px;
        }

        /* Calendar Days */
        .fc-daygrid-day {
            min-height: 120px !important;
        }

        .fc-day-today {
            background: #eef5ff !important;
        }

        /* Events */
        .fc-event {
            border: none !important;
            border-radius: 6px !important;
            padding: 4px 8px !important;
            font-size: 12px !important;
            font-weight: 700 !important;
            color: #fff !important;
            min-height: 24px !important;
            line-height: 16px !important;
            cursor: pointer;
        }

        .fc-event:hover {
            opacity: .9;
        }

        .fc-event-title {
            color: #fff !important;
            font-weight: 700 !important;
        }

        .fc-event-time {
            color: #fff !important;
            font-weight: 700 !important;
        }

        .fc-daygrid-event-dot {
            display: none !important;
        }

        .fc-theme-standard .fc-scrollgrid {
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #dee2e6;
        }

        /* Status Box */
        .legend-box {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            display: inline-block;
            margin-right: 8px;
        }
    </style>

    <div class="container-fluid py-4">

        <div class="row">

            <div class="col-lg-9">

                <div class="card shadow-sm calendar-card">

                    <div class="card-header bg-white">
                        <h4 class="mb-0 fw-bold">
                            <i class="bi bi-calendar-event"></i>
                            Event Calendar
                        </h4>
                    </div>

                    <div class="card-body">

                        <div id="calendar"></div>

                    </div>

                </div>

            </div>

            <div class="col-lg-3">

                <div class="card shadow-sm border-0">

                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">
                            Event Status
                        </h5>
                    </div>

                    <div class="card-body">

                        <p>
                            <span class="legend-box bg-secondary"></span>
                            Draft
                        </p>

                        <p>
                            <span class="legend-box bg-primary"></span>
                            Upcoming
                        </p>

                        <p>
                            <span class="legend-box bg-success"></span>
                            Ongoing
                        </p>

                        <p>
                            <span class="legend-box bg-info"></span>
                            Completed
                        </p>

                        <p>
                            <span class="legend-box bg-danger"></span>
                            Cancelled
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            let calendarEl = document.getElementById('calendar');

            let calendar = new FullCalendar.Calendar(calendarEl, {

                initialView: 'dayGridMonth',

                height: 750,

                dayMaxEvents: false,

                displayEventTime: true,

                eventDisplay: 'block',

                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },

                buttonText: {
                    today: 'Today',
                    month: 'Month',
                    week: 'Week',
                    day: 'Day'
                },

                events: "{{ route('calendar.events') }}",

                eventClick: function (info) {

                    info.jsEvent.preventDefault();

                    if (info.event.url) {
                        window.location.href = info.event.url;
                    }

                }

            });

            calendar.render();

        });
    </script>

@endsection