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
        Pusher.logToConsole = true;

        var pusher = new Pusher(
            '{{ config('broadcasting.connections.pusher.key') }}', {
                cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}'
            }
        );

        var member_id = "{{ auth()->guard('member')->user()->id }}";
        var workspace_id = "{{ current_workspace()->id }}";

        var channelName = 'workspace-notify-accept-' + workspace_id + '-' + member_id;

        var workspace_notify_accept_channel = pusher.subscribe(channelName);

        workspace_notify_accept_channel.bind(
            'App\\Events\\Workspace\\NotfiyAcceptToWorkspace',
            function(data) {
                $(document).Toasts('create', {
                    body: data.message,
                    title: data.title,
                    subtitle: data.date_time,
                    image: '{{ asset('public/img/user-solid-full.svg') }}',
                    imageAlt: 'User Picture',
                });
            }
        );
    </script>
</body>

</html>
