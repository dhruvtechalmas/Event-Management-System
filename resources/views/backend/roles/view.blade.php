<div class="modal fade" id="viewPermissionRoleModal{{ $role->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title btn btn-outline-info">
                    View Role
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label fw-bold">
                        Role Name
                    </label>

                    <input type="text"
                           class="form-control"
                           value="{{ $role->name }}"
                           readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">
                        Permissions
                    </label>

                    <div class="border rounded p-3">

                        @forelse ($role->permissions as $permission)
                            <span class="badge bg-primary me-1 mb-2 p-2">
                                {{ $permission->name }}
                            </span>
                        @empty
                            <span class="badge bg-secondary">
                                No Permissions
                            </span>
                        @endforelse

                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">
                        Created Date
                    </label>

                    <input type="text"
                           class="form-control"
                           value="{{ $role->created_at->format('d-m-Y') }}"
                           readonly>
                </div>

            </div>

        </div>
    </div>
</div>