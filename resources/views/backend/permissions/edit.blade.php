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

<div class="modal fade" id="editPermissionModal{{ $permission->id }}" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Permission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body"></div>

            <div class="px-2 px-md-3">
                <form action="{{ route('permissions.update', $permission->id) }}" method="POST" class="needs-validation"
                    novalidate>
                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        <div class="col-md-12">
                            <label class="form-label" for="PermissionName">Permission Name</label>
                            <input class="form-control" id="name" name="name" value="{{ $permission->name }}"
                                type="text" placeholder="Enter Permission Name" required>
                            <div class="invalid-feedback">Permission name is required.</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-3">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-person-check"></i>
                            Update Permission
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>