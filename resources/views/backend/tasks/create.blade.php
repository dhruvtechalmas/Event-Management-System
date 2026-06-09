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
    <form action="{{ route('tasks.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        <div class="row g-3">
            <div class="col-md-12">
                <label class="form-label" for="title">Taks Title</label>
                <input class="form-control" id="title" name="title" type="text" placeholder="Enter Task Title" required>
                <div class="invalid-feedback">Task Title is required.</div>
            </div>

            <div class="col-md-12">
                <label class="form-label" for="event_id">Event</label>
                <select class="form-control" id="event_id" name="event_id" required>
                    <option value="">Select an Event</option>
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}">{{ $event->event_name }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Please select an event.</div>
            </div>

            <div class="col-md-12">
                <label class="form-label" for="assigned_to">Assign Task</label>
                <select class="form-control" id="assigned_to" name="assigned_to">
                    <option value="">Select an User</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                {{-- <div class="invalid-feedback">Please select an User.</div> --}}
            </div>

            <div class="col-md-12">
                <label class="form-label" for="due_date">Due Date</label>
                <input class="form-control" id="due_date" name="due_date" type="date" placeholder="Enter Phone"
                    required>
                <div class="invalid-feedback">Due Date is required.</div>
            </div>

            <div class="col-md-12">
                <label class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="">Select Status</option>
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="completed">Completed</option>
                </select>
            </div>

            <div class="col-md-12">
                <label class="form-label" for="comment">comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"
                    placeholder="Enter Notes (Optional)"></textarea>
            </div>

        </div>

        <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-3">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Cancel
            </button>

            <button class="btn btn-primary" type="submit">
                <i class="bi bi-person-check"></i>
                Create Task
            </button>
        </div>

    </form>
</div>