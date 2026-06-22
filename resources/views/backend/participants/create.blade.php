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

<div class="px-2 px-md-3">
    <form action="{{ route('participants.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        <div class="row g-3">

            <div class="col-md-12">
                <label class="form-label" for="ParticipantName">Participant Name</label>
                <input class="form-control" id="full_name" name="full_name" value="{{ old('full_name') }}" type="text"
                    placeholder="Enter Participant Name" required>
                <div class="invalid-feedback">Participant name is required.</div>
            </div>

            <div class="col-md-12">
                <label class="form-label" for="email">Email</label>
                <input class="form-control" id="email" name="email" value="{{ old('email') }} type="email" placeholder="Enter Email" required>
                <div class="invalid-feedback">Enter a valid email.</div>
            </div>

             <div class="col-md-12">
                <label class="form-label" for="event_id">Event</label>
                <select class="form-control" id="event_id" name="event_id" value="{{ old('event_id') }} required>
                    <option value="">Select an Event</option>
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}">{{ $event->event_name }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Please select an event.</div>
            </div>

            <div class="col-md-12">
                <label class="form-label" for="phone">Phone</label>
                <input class="form-control" id="phone" name="phone" value="{{ old('phone') }} type="text" placeholder="Enter Phone" 
                 maxlength="10"  oninput="this.value=this.value.replace(/[^0-9]/g,'')" required>
                <div class="invalid-feedback">Phone number is required.</div>
            </div>

            <div class="col-md-12">
                <label class="form-label" for="address">Address</label>
                <input class="form-control" id="address" name="address" value="{{ old('address') }} type="text" placeholder="Enter Address" required>
                <div class="invalid-feedback">Address is required.</div>
            </div>

            <div class="col-md-12">
                <label class="form-label" for="notes">Notes</label>
                <textarea class="form-control" id="notes" name="notes" rows="3"
                    placeholder="Enter Notes (Optional)"></textarea>
            </div>

        </div>

        <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-3">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Cancel
            </button>

            <button class="btn btn-primary" type="submit">
                <i class="bi bi-person-check"></i>
                Create Participant
            </button>
        </div>

    </form>
</div>

