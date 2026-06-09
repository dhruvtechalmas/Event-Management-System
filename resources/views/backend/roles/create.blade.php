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
    <form action="{{ route('roles.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        <div class="row g-3 ">

            {{-- Role Name --}}
            <div class="col-md-4">
                <label class="form-label" for="RoleName">Role Name</label>
                <input class="form-control" id="name" name="name" type="text" placeholder="Enter Role Name" required>
                <div class="invalid-feedback">Role name is required.</div>
            </div>

            {{-- Permissions --}}
            <div class="col-md-12">
                <label class="form-label fw-bold">Assign Permissions</label>

                <div class="row border rounded p-3">
                    @foreach ($permissions as $permission)
                        <div class="col-md-4 col-sm-6 mb-2 ">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                    value="{{ $permission->name }}" id="permission{{ $permission->id }}">

                                <label class="form-check-label" for="permission{{ $permission->id }}">
                                    {{ ucfirst($permission->name) }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-3">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Cancel
            </button>

            <button class="btn btn-primary" type="submit">
                <i class="bi bi-person-check"></i>
                Create Role
            </button>
        </div>

    </form>
</div>