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

<div class="modal fade" id="editRoleModal{{ $role->id }}" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">

                <div class="px-2 px-md-3">
                 <form action=" {{ route('roles.update', $role->id) }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="row g-3 ">

                        {{-- Role Name --}}
                        <div class="col-md-4">
                            <label class="form-label" for="RoleName">Role Name</label>
                            <input class="form-control" id="name" name="name"  value="{{ $role->name }}" type="text" placeholder="Enter Role Name"
                                required>
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
                                                value="{{ $permission->name }}" {{ $role->permissions->contains('name', $permission->name) ? 'checked' : '' }}>

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
                            Edit Role
                        </button>
                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>