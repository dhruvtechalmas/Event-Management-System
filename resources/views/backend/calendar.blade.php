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
        min-height: 800px;
    }

    /* Header */
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
        padding: 12px 0;
        font-weight: 700;
        font-size: 14px;
    }

    /* Days */
    .fc-daygrid-day {
        min-height: 130px !important;
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
        font-weight: 600 !important;
        color: #fff !important;
        cursor: pointer;
    }

    .fc-event:hover {
        opacity: .9;
    }

    .fc-event-title,
    .fc-event-time {
        color: #fff !important;
        font-weight: 600 !important;
    }

    .fc-theme-standard .fc-scrollgrid {
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid #dee2e6;
    }

    /* Status Row */
    .status-list {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 25px;
        margin-top: 12px;
    }

    .status-item {
        display: flex;
        align-items: center;
        font-size: 14px;
        font-weight: 600;
        color: #495057;
    }

    .legend-box {
        width: 15px;
        height: 15px;
        border-radius: 4px;
        margin-right: 8px;
    }
</style>

<div class="container-fluid py-4">

    <div class="row">

        <div class="col-12">

            <div class="card shadow-sm calendar-card">

                <div class="card-header bg-white">

                    <h4 class="mb-0 fw-bold">
                        <i class="bi bi-calendar-event"></i>
                        Event Calendar
                    </h4>

                    <!-- Horizontal Status Row -->
                    <div class="status-list">

                        <div class="status-item">
                            <span class="legend-box bg-secondary"></span>
                            Draft
                        </div>

                        <div class="status-item">
                            <span class="legend-box bg-primary"></span>
                            Upcoming
                        </div>

                        <div class="status-item">
                            <span class="legend-box bg-success"></span>
                            Ongoing
                        </div>

                        <div class="status-item">
                            <span class="legend-box bg-info"></span>
                            Completed
                        </div>

                        <div class="status-item">
                            <span class="legend-box bg-danger"></span>
                            Cancelled
                        </div>

                    </div>

                </div>

                <div class="card-body p-4">

                    <div id="calendar"></div>

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

        height: 850,

        dayMaxEvents: true,

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

        eventClick: function(info) {

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