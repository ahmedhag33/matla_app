 @include('admin_layouts.script')
 <script>
     function logout() {
         Swal.fire({
             title: "<b>{{ __('Do you want to log out??') }}</b>",
             icon: "warning",
             iconColor: "#17233C",
             showCancelButton: true,
             confirmButtonColor: "#17233C",
             cancelButtonColor: "#F59E0B",
             confirmButtonText: "{{ __('Logout') }}",
             cancelButtonText: "{{ __('Cancel') }}"
         }).then((result) => {
             if (result.isConfirmed) {
                 window.location.href = "";
             }
         });
     }
 </script>
 @yield('script')
