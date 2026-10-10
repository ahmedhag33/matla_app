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
 <script>
     function logout() {
         Swal.fire({
             title: "{{ __('Do you want to log out??') }}",
             icon: "warning",
             showCancelButton: true,
             confirmButtonColor: "#3085d6",
             cancelButtonColor: "#d33",
             confirmButtonText: "{{ __('Logout') }}"
         }).then((result) => {
             if (result.isConfirmed) {
                 window.location.href = "{{ route('dashboard.auth.logout') }}";
             }
         });
     }
 </script>
 @yield('script')
