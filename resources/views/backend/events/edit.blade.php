{{-- Show a validation error message --}}
@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="modal fade" id="editEventModal{{ $event->id }}" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">

                <div class="px-2 px-md-3">
                    <form action="{{ route('events.update', $event->id) }}" method="POST" class="needs-validation"
                        novalidate>
                        @csrf
                        @method('PUT')
                        <div class="row g-3">

                            <div class="col-md-12">
                                <label class="form-label" for="EventName">Event Name</label>
                                <input class="form-control" id="event_name" name="event_name"
                                    value="{{ $event->event_name }}" type="text" placeholder="Enter Event Name"
                                    required>
                                <div class="invalid-feedback">Event name is required.</div>
                            </div>

                            {{-- @error('event_name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror --}}

                            <div class="col-md-12">
                                <label class="form-label" for="eventType">Event Type</label>
                                <input class="form-control" id="event_type" name="event_type"
                                    value="{{ $event->event_type }}" type="text" placeholder="Enter Event Type"
                                    required>
                                <div class="invalid-feedback">Enter a valid event type.</div>
                            </div>

                            {{-- @error('event_type')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror --}}

                            <div class="col-md-12">
                                <label class="form-label" for="eventDate">Event Date</label>
                                <input class="form-control" id="event_date" name="event_date"
                                    value="{{ $event->event_date }}" type="date" placeholder="Enter Event Date"
                                    required>
                                <div class="invalid-feedback">Event date is required.</div>
                            </div>

                            {{-- @error('event_date')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror --}}

                            <div class="col-md-12">
                                <label class="form-label" for="eventTime">Event Time</label>
                                <input class="form-control" id="event_time" name="event_time"
                                    value="{{ $event->event_time }}" type="time" placeholder="Enter Event Time"
                                    required>
                                <div class="invalid-feedback">Event time is required.</div>
                            </div>

                            {{-- @error('event_time')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror --}}

                            <div class="col-md-12">
                                <label class="form-label" for="eventLocation">Event Location</label>
                                <input class="form-control" id="event_location" name="event_location"
                                    value="{{ $event->event_location }}" type="text" placeholder="Enter Event Location"
                                    required>
                                <div class="invalid-feedback">Event location is required.</div>
                            </div>

                            {{-- @error('event_location')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror --}}

                            <div class="col-md-12">
                                <label class="form-label" for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"
                                    placeholder="Enter Event Description (Optional)">{{ $event->description }}</textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control" value="{{ $event->status }}" required>
                                    <option value="">Select Status</option>
                                    <option value="Draft" {{ $event->status == 'Draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="Upcoming" {{ $event->status == 'Upcoming' ? 'selected' : '' }}>Upcoming
                                    </option>
                                    <option value="Ongoing" {{ $event->status == 'Ongoing' ? 'selected' : '' }}>Ongoing
                                    </option>
                                    <option value="Completed" {{ $event->status == 'Completed' ? 'selected' : '' }}>
                                        Completed</option>
                                    <option value="Cancelled" {{ $event->status == 'Cancelled' ? 'selected' : '' }}>
                                        Cancelled</option>
                                </select>
                            </div>

                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-3">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                Cancel
                            </button>

                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-person-check"></i>
                                Update Event
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>