@include('backend.layout.header')
@yield('content')
@include('backend.layout.footer')

{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> --}}

{{-- Todtr message --}}

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

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


<script>
    window.userId = {{ auth()->id() }};
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    if (!window.userId || !window.Echo) {
        return;
    }

    window.Echo
        .private(`App.Models.User.${window.userId}`)
        .notification((notification) => {

            console.log('Realtime Notification:', notification);

            updateNotification(notification);

        });

});
</script>

<script>
function updateNotification(notification)
{
    let badge = $('#notif-badge');

    let count = parseInt(badge.text()) || 0;

    count++;

    badge
        .text(count)
        .removeClass('d-none');

    $('#notif-header-text')
        .text(`Notifications (${count} Unread)`);

    $('#no-notif-msg').remove();

    let html = `
        <a 
        class="dropdown-item d-flex flex-column py-2 border-bottom">

            <span class="fw-bold">
                ${notification.title}
            </span>

            <small>
                ${notification.message}
            </small>

            <span class="text-muted small">
                Just now
            </span>

        </a>
    `;

    $('#notification-list-container')
        .prepend(html);

    toastr.success(notification.message);
}
</script>



<script>

   $(document).on('click', '#mark-all-read-btn', function (e) {

      e.preventDefault();

      $.ajax({

         url: "{{ route('notifications.markAllRead') }}",
         type: "GET",

         success: function (response) {

            // Remove all notification items
            $('#notification-list-container').html(`
                <div id="no-notif-msg"
                    class="text-center py-4 text-muted"
                    style="font-size: 0.85rem;">
                    No new unread notifications
                </div>
            `);

            // Hide badge
            $('#notif-badge')
               .text('0')
               .addClass('d-none');

            // Update header text
            $('#notif-header-text')
               .text('Notifications (0 Unread)');

            // Hide mark all read button
            $('#mark-all-read-btn')
               .addClass('d-none');

         },

         error: function (xhr) {

            console.log(xhr);

            alert('Something went wrong!');

         }

      });

   });

</script>