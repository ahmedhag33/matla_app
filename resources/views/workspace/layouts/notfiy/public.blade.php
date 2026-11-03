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
    var noNotificationsElem = $('.no-notifications');
</script>
