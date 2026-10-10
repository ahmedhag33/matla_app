 <script src="{{ asset('public/dashboard/plugins/jquery/jquery.min.js') }}"></script>
 <!-- Bootstrap 4 -->
 <script src="{{ asset('public/dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
 <!-- AdminLTE App -->
 <script src="{{ asset('public/dashboard/dist/js/adminlte.min.js') }}"></script>
 <script src="{{ asset('public/js/toastr.min.js') }}"></script>
 <script src="{{ asset('public/js/sweetalert2@11.js') }}"></script>
 <script>
     toastr.options = {
         "closeButton": true,
         "debug": false,
         "newestOnTop": false,
         "progressBar": true,
         "positionClass": "toast-top-left",
         "preventDuplicates": true,
         "onclick": null,
         "showDuration": "300",
         "hideDuration": "1000",
         "timeOut": "5000",
         "extendedTimeOut": "1000",
         "showEasing": "swing",
         "hideEasing": "linear",
         "showMethod": "fadeIn",
         "hideMethod": "fadeOut"
     }
 </script>
