{{-- Show a validation error message --}}
{{-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif --}}

<div class="modal fade" id="editTaskModal{{ $task->id }}" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">

                <div class="px-2 px-md-3">
                    <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label" for="title">Taks Title</label>
                                <input class="form-control" id="title" name="title" value="{{ $task->title }}"type="text"
                                    placeholder="Enter Task Title" required>
                                <div class="invalid-feedback">Task Title is required.</div>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label" for="event_id">Event</label>
                                <select class="form-control" id="event_id" name="event_id"
                                    value="{{ $task->event_id }}" required>
                                    <option value="">Select an Event</option>
                                    @foreach ($events as $event)
                                        <option value="{{ $event->id }}" {{ $task->event_id == $event->id ? 'selected' : '' }}>
                                            {{ $event->event_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select an event.</div>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label" for="assigned_to">Assign Task</label>
                                <select class="form-control" id="assigned_to" name="assigned_to" value="{{ $task->assigned_to }}" required>
                                    <option value="">Select an User</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ $task->assigned_to == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select an User.</div>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label" for="due_date">Due Date</label>
                                <input class="form-control" id="due_date" name="due_date" value="{{ $task->due_date }}" type="date"
                                    placeholder="Enter Due Date" required>
                                <div class="invalid-feedback">Due Date is required.</div>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Status</label>
                                <select name="status" value="{{ $task->status }}" class="form-control" required>
                                    <option value="">Select Status</option>
                                    <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="in_progress"{{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                                <div class="invalid-feedback">Task Status is required.</div>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label" for="comment">comment</label>
                                <textarea class="form-control" id="comment" name="comment" value="{{ $task->comment }}" rows="3"
                                    placeholder="Enter Notes (Optional)"></textarea>
                            </div>

                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-3">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                Cancel
                            </button>

                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-person-check"></i>
                                Update Task
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>