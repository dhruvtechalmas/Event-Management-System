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

<div class="modal fade" id="assigncreateTaskModal{{ $task->id }}" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Assign Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">
                <div class="px-2 px-md-3">
                    <form action="{{ route('tasks.assigntask', $task->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PATCH')
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


                        <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-3">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                Cancel
                            </button>

                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-person-check"></i>
                                Asssign Task
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>