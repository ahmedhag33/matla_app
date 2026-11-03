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
