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
                window.location.href = "{{ route('workspace.member.logout') }}";
            }
        });
    }
</script>
@if (session()->has('success-message-user-verify'))
    <script>
        toastr.success("{{ session()->get('success-message-user-verify') }}");
    </script>
@endif
@if (session()->has('login-success'))
    <script>
        toastr.success("{{ session()->get('login-success') }}");
    </script>
@endif
@if (session()->has('auth-member-message'))
    <script>
        toastr.success("{{ session()->get('auth-member-message') }}");
    </script>
@endif
@yield('script')
