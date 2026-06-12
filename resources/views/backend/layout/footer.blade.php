<footer class="admin-footer">
  <div class="container-fluid px-3 px-lg-4">
    <span>Copyright 2026 adminHMD. <br> Developed by <a target="_blank" class="fw-bold text-success"
        href="https://github.com/HasanMahmudDev">Md. Hasan Mahmud</a> • Distributed by <a target="_blank"
        class="fw-bold text-success" href="https://themewagon.com">ThemeWagon</a> </span>
    <span>Professional dashboard template.</span>
    <span>Form component examples.</span>
  </div>
</footer>
</div>
</div>

<script>
  window.adminHMDUser = {
    name: "{{ auth()->user()->name }}",
    role: "{{ auth()->user()->getRoleNames()->first() }}",
    workspace: "Active Workspace",
    avatar: "{{ asset('backend/assets/images/avatar/avatar-2.jpg') }}"
  };
</script>

<script src="{{ asset('backend/assets/js/app.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="{{ url('/backend/assets/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ url('/backend/assets/js/main.js') }}"></script>


</body>

</html>