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
    <script>
        Pusher.logToConsole = {{ config('broadcasting.pusher_console') }};

        var pusher = new Pusher(
            '{{ config('broadcasting.connections.pusher.key') }}', {
                cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}'
            }
        );
        var notificationsWrapper = $('.dropdown-notifications');
        var notificationsToggle = $('.dropdown-notifications-toggle');
        var notificationsCountElem = notificationsToggle.find('span[data-count]');
        var notificationsCount = parseInt(notificationsCountElem.data('count'), 10) || 0;
        var count_notifications = $('.count-notifications');
        var member_id = @json(auth()->guard('member')->id());
        var workspace_id = @json(current_workspace()->id);

        var channelName = 'workspace-notify-accept-' + workspace_id + '-' + member_id;

        var workspace_notify_accept_channel = pusher.subscribe(channelName);

        workspace_notify_accept_channel.bind(
            'App\\Events\\Workspace\\NotfiyAcceptToWorkspace',
            function(data) {
                var newNotificationHtml = `<a href="${data.url}" class="dropdown-item">
                         <!-- Message Start -->
                         <div class="media">
                             <img src="${data.photo}" alt="User Avatar"
                                  class="img-size-50 mr-3 img-circle">
                             <div class="media-body">
                                 <h3 class="dropdown-item-title">
                                     ${data.title}
                                 </h3>
                                 <p class="text-sm">${data.message}</p>
                                 <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>
                                     ${data.date_time}</p>
                             </div>
                         </div>
                         <!-- Message End -->
                     </a>`;

                notificationsWrapper.prepend(newNotificationHtml);
                notificationsCount += 1;
                notificationsCountElem.data('count', notificationsCount);
                notificationsCountElem.text(notificationsCount);
                count_notifications.data('count', notificationsCount);
                count_notifications.text(notificationsCount);
            }
        );
    </script>
    <script>
        $(document).on('click', '.read-notification', function(e) {
            e.preventDefault();
            var notificationId = $(this).data('notification-id');
            var url = $(this).attr('href');
            var notification = $(this);
            $.ajax({
                url: "{{ route('workspace.dashboard.read-notification', ['slug' => request()->route('slug')]) }}",
                method: "POST",
                data: {
                    id: notificationId,
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
