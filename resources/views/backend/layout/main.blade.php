@include('backend.layout.header')
@yield('content')
@include('backend.layout.footer')
<script src="{{ url('backend/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ url('backend/assets/js/main.js') }}"></script>

{{-- Todtr message --}}

<!-- Put this in the <head> section -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

<!-- Put these before the closing </body> tag -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Custom Premium Dark Cream CSS Styling -->
<style>
   /* Toastr container styling */
   #toast-container>div {
      background-color: hsl(187, 88%, 40%) !important;
      /* Premium Dark Chocolate/Cream Charcoal */
      color: #f4ebd9 !important;
      /* Soft Cream Text */
      border: 1px solid rgb(16, 248, 248) !important;
      /* Subtle Border */
      box-shadow: 0 10px 30px rgba(18, 172, 172, 0.5) !important;
      border-radius: 8px !important;
      opacity: 1 !important;
      font-family: 'Segoe UI', Roboto, sans-serif;
   }

   /* Icon aur Close button ka color adjust karne ke liye */
   #toast-container .toast-close-button {
      color: #f4ebd9 !important;
      text-shadow: none !important;
      top: 8px !important;
      right: 8px !important;
   }

   /* Success Toast Highlight */
   #toast-container>.toast-success {
      border-left: 5px solid #d4af37 !important;
      /* Elegant Gold Accent */
   }

   /* Error Toast Highlight */
   #toast-container>.toast-error {
      border-left: 5px solid #de6b48 !important;
      /* Soft Terracotta/Red Accent */
   }

   /* Progress Bar (Underline Timeout Animation) */
   #toast-container>div .toast-progress {
      height: 3px !important;
      opacity: 0.8 !important;
   }

   /* Success progress bar color (Gold/Cream tint) */
   #toast-container>.toast-success .toast-progress {
      background-color: #d4af37 !important;
   }

   /* Error progress bar color */
   #toast-container>.toast-error .toast-progress {
      background-color: #de6b48 !important;
   }
</style>

<!-- Script Logic with Animation & Progress Bar Options -->
<script>
   @if(Session::has('message'))
      // Toastr configurations for smooth animations and timeout underline
      toastr.options = {
         "closeButton": true,
         "progressBar": true,          /* Isse underline timeout progress bar dikhegi */
         "positionClass": "toast-top-right",
         "showDuration": "400",         /* Fade in speed */
         "hideDuration": "400",         /* Fade out speed */
         "timeOut": "3000",             /* 5 seconds tak message dikhega */
         // "extendedTimeOut": "2000",     /* Hover karne par 2 second extra milenge */
         "showEasing": "swing",
         "hideEasing": "linear",
         "showMethod": "fadeIn",        /* Premium fade animation */
         "hideMethod": "fadeOut"
      };

      var type = "{{ Session::get('alert-type', 'success') }}";
      var message = "{{ Session::get('message') }}";

      switch (type) {
         case 'success':
            toastr.success(message);
            break;
         case 'error':
            toastr.error(message);
            break;
         default:
            toastr.success(message);
            break;
      }
   @endif
</script>