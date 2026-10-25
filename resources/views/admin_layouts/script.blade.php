 <script src="{{ asset('public/dashboard/plugins/jquery/jquery.min.js') }}"></script>
 <!-- Bootstrap 4 -->
 <script src="{{ asset('public/dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
 <!-- AdminLTE App -->
 <script src="{{ asset('public/dashboard/dist/js/adminlte.min.js') }}"></script>
 <script src="{{ asset('public/js/toastr.min.js') }}"></script>
 <script src="{{ asset('public/js/sweetalert2@11.js') }}"></script>
 <script src="{{ asset('public/dashboard/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"
     type="text/javascript"></script>
 <script src="{{ asset('public/dashboard/plugins/select2/js/select2.full.min.js') }}"></script>
 <!-- Bootstrap4 Duallistbox -->
 <script src="{{ asset('public/dashboard/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}">
 </script>
 <!-- InputMask -->
 <script src="{{ asset('public/dashboard/plugins/moment/moment.min.js') }}"></script>
 <script src="{{ asset('public/dashboard/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
 <!-- date-range-picker -->
 <script src="{{ asset('public/dashboard/plugins/daterangepicker/daterangepicker.js') }}"></script>
 <!-- bootstrap color picker -->
 <script src="{{ asset('public/dashboard/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
 <!-- Tempusdominus Bootstrap 4 -->
 <script src="{{ asset('public/dashboard/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}">
 </script>
 <!-- Bootstrap Switch -->
 <script src="{{ asset('public/dashboard/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
 <!-- BS-Stepper -->
 <script src="{{ asset('public/dashboard/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
 <!-- dropzonejs -->
 <script src="{{ asset('public/dashboard/plugins/dropzone/min/dropzone.min.js') }}"></script>
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
 <script>
     function togglePasswordVisibility(inputId, toggleId) {
         $('#' + toggleId).on('click', function() {
             const password = $('#' + inputId);

             if (password.attr('type') === 'password') {
                 password.attr('type', 'text');

                 $(this).attr(
                     'src',
                     "{{ asset('public/img/eye-slash-solid-full.svg') }}"
                 );
             } else {
                 password.attr('type', 'password');

                 $(this).attr(
                     'src',
                     "{{ asset('public/img/eye-solid-full.svg') }}"
                 );
             }
         });
     }
 </script>
 @if (session()->has('error-message-permission'))
     <script>
         toastr.error("{{ session('error-message-permission') }}");
     </script>
 @endif
