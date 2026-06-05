{{-- Show a validation error message  --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="px-2 px-md-3">
    <form action="{{ route('events.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        <div class="row g-3">

            <div class="col-md-12">
                <label class="form-label" for="EventName">Event Name</label>
                <input class="form-control" id="event_name" name="event_name" type="text" placeholder="Enter Event Name"
                    required>
                <div class="invalid-feedback">Event name is required.</div>
            </div>

            <div class="col-md-12">
                <label class="form-label" for="eventType">Event Type</label>
                <input class="form-control" id="event_type" name="event_type" type="text" placeholder="Enter Event Type"
                    required>
                <div class="invalid-feedback">Enter a valid event type.</div>
            </div>

            <div class="col-md-12">
                <label class="form-label" for="eventDate">Event Date</label>
                <input class="form-control" id="event_date" name="event_date" type="date" placeholder="Enter Event Date"
                    required>
                <div class="invalid-feedback">Event date is required.</div>
            </div>

            <div class="col-md-12">
                <label class="form-label" for="eventTime">Event Time</label>
                <input class="form-control" id="event_time" name="event_time" type="time" placeholder="Enter Event Time"
                    required>
                <div class="invalid-feedback">Event time is required.</div>
            </div>

            <div class="col-md-12">
                <label class="form-label" for="eventLocation">Event Location</label>
                <input class="form-control" id="event_location" name="event_location" type="text"
                    placeholder="Enter Event Location" required>
                <div class="invalid-feedback">Event location is required.</div>
            </div>

            <div class="col-md-12">
                <label class="form-label" for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"
                    placeholder="Enter Event Description (Optional)"></textarea>
            </div>

            <div class="col-md-12">
                <label class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="">Select Status</option>
                    <option value="Draft">Draft</option>
                    <option value="Upcoming">Upcoming</option>
                    <option value="Ongoing">Ongoing</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
            </div>

        </div>

        <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-3">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Cancel
            </button>

            <button class="btn btn-primary" type="submit">
                <i class="bi bi-person-check"></i>
                Create Event
            </button>
        </div>

    </form>
</div>