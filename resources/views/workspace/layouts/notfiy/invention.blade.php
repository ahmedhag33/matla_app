<script>
    var channelName = 'workspace-notify-accept-' + workspace_id + '-' + member_id;

    var workspace_notify_accept_channel = pusher.subscribe(channelName);

    workspace_notify_accept_channel.bind(
        'App\\Events\\Workspace\\NotfiyAcceptToWorkspace',
        function(data) {
            var newNotificationHtml = `<a href="${data.url}" class="dropdown-item read-notification"
    data-notification-code="${data.code}">
    <!-- Message Start -->
    <div class="media">
        <img src="${data.photo}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
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
            count_notifications.show();
            count_notifications.data('count', notificationsCount);
            count_notifications.text(notificationsCount);
            noNotificationsElem.hide();

        }
    );
</script>
