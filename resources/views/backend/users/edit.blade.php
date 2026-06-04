<div class="px-2 px-md-3">
  <form action="{{ route('users.update', $user->id) }}" method="POST" class="needs-validation" novalidate>
    @csrf
    @method('PUT')

    <div class="row g-3">

      <div class="col-md-12">
        <label class="form-label" for="firstName">Full Name</label>
        <input class="form-control" id="firstName" name="name" type="text" value="{{ $user->name }}" required>
        <div class="invalid-feedback">Full name is required.</div>
      </div>

      <div class="col-md-12">
        <label class="form-label" for="email">Email</label>
        <input class="form-control" id="email" name="email" type="email" value="{{ $user->email }}" required>
        <div class="invalid-feedback">Enter a valid email.</div>
      </div>

      <div class="col-md-12">
        <label class="form-label" for="phone">Phone</label>
        <input class="form-control" id="phone" name="phone" type="tel" value="{{ $user->phone }}" required>
        <div class="invalid-feedback">Phone number is required.</div>
      </div>

      <div class="col-md-12">
        <label class="form-label" for="role">Role</label>
        <select class="form-select" id="role" name="role_id" required>
          <option value="">Choose Role</option>
          @foreach($roles as $role)
            <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
              {{ $role->name }}
            </option>
          @endforeach
        </select>
        <div class="invalid-feedback">Choose a role.</div>
      </div>

    </div>

    <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-3">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
        Cancel
      </button>

      <button class="btn btn-primary" type="submit">
        <i class="bi bi-person-check"></i>
        Update User
      </button>
    </div>

  </form>
</div>