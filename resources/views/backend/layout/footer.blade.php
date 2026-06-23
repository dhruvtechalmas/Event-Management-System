<!-- ================= Footer ================= -->

{{-- <footer class="admin-footer border-top bg-white py-3 mt-auto">
    <div class="container-fluid px-3 px-lg-4">

    <div class="row align-items-center gy-3">

        <!-- Left Side -->
        <div class="col-lg-4 text-center text-lg-start">
            <h6 class="fw-bold text-dark mb-1">
                Event Management System (EMS)
            </h6>

            <p class="text-muted small mb-0">
                Manage events, participants, tasks, and notifications
                from one centralized dashboard.
            </p>
        </div>

        <!-- Center -->
        <div class="col-lg-4 text-center">
            <p class="mb-1 text-muted small">
                © {{ date('Y') }}
                <strong class="text-dark">
                    Event Management System
                </strong>.
                All Rights Reserved.
            </p>

            <p class="mb-0 text-muted small">
                Developed by
                <span class="fw-semibold text-primary">
                    Dhruv Padhiyar
                </span>
                • PHP Laravel Developer
            </p>
        </div>

        <!-- Right Side -->
        <div class="col-lg-4 text-center text-lg-end">
            <p class="mb-1 text-muted small">
                Version
                <span class="fw-semibold text-dark">
                    1.0.0
                </span>
            </p>

            <p class="mb-0 text-muted small">
                Built with
                <i class="bi bi-heart-fill text-danger"></i>
                using
                <span class="fw-semibold text-dark">Laravel 13</span>
                &
                <span class="fw-semibold text-dark">Bootstrap 5</span>
            </p>
        </div>

    </div>

</div>
</div> --}}

<script>
    window.adminHMDUser = {
        name: "{{ auth()->user()->name }}",
        role: "{{ auth()->user()->getRoleNames()->first() }}",
        workspace: "Event Management System",
        avatar: "{{ asset('backend/assets/images/avatar/avatar-2.jpg') }}"
    };
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script> --}}
<script src="{{ asset('backend/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/main.js') }}"></script>


</body>
</html>
