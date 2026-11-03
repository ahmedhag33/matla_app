<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
@if (getCurrentLanguage() == 'ar')
    <html lang="ar" dir="rtl">
@else
    <html lang="en">
@endif

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Home') }}</title>

    <!-- Google Font: Source Sans Pro -->
    @include('workspace.layouts.link')
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        @include('workspace.layouts.nav')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('workspace.layouts.sidebar')

        <!-- Content Wrapper. Contains page content -->
        @yield('content')
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    @include('workspace.layouts.script')
    <script>
        $('.dropdown-notifications-toggle').on('click', function() {
            $('.dropdown-notifications').toggle();
        });
    </script>
    @include('workspace.layouts.notfiy.public')

    @include('workspace.layouts.notfiy.invention')
    @include('workspace.layouts.notfiy.program')
    <script>
        $(document).on('click', '.read-notification', function(e) {
            e.preventDefault();
            var notificationCode = $(this).data('notification-code');
            var url = $(this).attr('href');
            var notification = $(this);
            $.ajax({
                url: "{{ route('workspace.dashboard.read-notification', ['slug' => request()->route('slug')]) }}",
                method: "POST",
                data: {
                    code: notificationCode,
                    _token: "{{ csrf_token() }}"
                },
                success: function() {
                    notification.remove();
                    window.location.href = url;
                }
            });
        });
    </script>
</body>

</html>
