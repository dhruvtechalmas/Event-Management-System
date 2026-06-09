<div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">

                <form action="{{ route('users.update', $user->id) }}"
                      method="POST">

                    @csrf
                   @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ $user->name }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email"
                               name="email"
                               class="form-control"
                               value="{{ $user->email }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text"
                               name="phone"
                               class="form-control"
                               value="{{ $user->phone }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role</label>

                        <select name="role_id" class="form-select">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}"
                                    {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="text-end">
                        <button type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit"
                                class="btn btn-primary">
                            Update User
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>