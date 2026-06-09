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
    <form action="{{ route('permissions.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        <div class="row g-3">

            <div class="col-md-12">
                <label class="form-label" for="PermissionName">Permission Name</label>
                <input class="form-control" id="name" name="name" type="text"
                    placeholder="Enter Permission Name" required>
                <div class="invalid-feedback">Permission name is required.</div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-3">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Cancel
            </button>

            <button class="btn btn-primary" type="submit">
                <i class="bi bi-person-check"></i>
                Create Permission
            </button>
        </div>

    </form>
</div>

