@if (session()->has('error-message-user'))
    <script>
        toastr.error("{{ session()->get('error-message-user') }}");
        $('#login').modal('show');
    </script>
@endif
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
@if (session()->has('error-message-user-verify'))
    <script>
        toastr.error("{{ session()->get('error-message-user-verify') }}");
    </script>
@endif
<script>
    $('.portfolio-filters .filter').on('click', function() {
        $('.portfolio-filters .filter').removeClass('active');
        $(this).addClass('active');

        let target = $(this).data('target');

        $('#login_box, #register_box').hide();
        $('#' + target).fadeIn(200);
    });
</script>
<script>
    $('#forget_password').on('click', function() {
        $('#ui-filters-login-register').hide();
        $('#login_box, #register_box').hide();
        $('#forget_password_box').show();
    });
</script>
<script>
    $(document).ready(function() {
        $('#check').click(function() {
            $(this).is(':checked') ? $('#password').attr('type', 'text') : $('#password').attr(
                'type', 'password');
        });
        $('#check_register').click(function() {
            $(this).is(':checked') ? $('#register_password').attr('type', 'text') : $(
                '#register_password').attr(
                'type', 'password');
            $(this).is(':checked') ? $('#password_confirmation').attr('type', 'text') : $(
                '#password_confirmation').attr(
                'type', 'password');
        });
        $('#check_reset_password').click(function() {
            $(this).is(':checked') ? $('#reset_password').attr('type', 'text') : $('#reset_password')
                .attr(
                    'type', 'password');
            $(this).is(':checked') ? $('#reset_password_confirmation').attr('type', 'text') : $(
                '#reset_password_confirmation').attr(
                'type', 'password');
        });
        $('#create_password').change(function() {
            var password = "{{ passwordGenerator() }}";
            if ($(this).is(':checked')) {
                $('#register_password').val(password);
                $('#password_confirmation').val(password);
            } else {
                $('#register_password').val('');
                $('#password_confirmation').val('');
            }
        });
        $('#create_reset_password').change(function() {
            var password = "{{ passwordGenerator() }}";
            if ($(this).is(':checked')) {
                $('#reset_password').val(password);
                $('#reset_password_confirmation').val(password);
            } else {
                $('#reset_password').val('');
                $('#reset_password_confirmation').val('');
            }
        });
        $(document).on('click', '#btn-register', function(e) {
            e.preventDefault();
            var formData = new FormData($('#register-form')[0]);
            $.ajax({
                type: 'post',
                enctype: "multipart/form-data",
                url: "{{ route('client-register') }}",
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $('#register-loading').show();
                    $('#register-form').hide();
                    $('#google-login').hide();
                },
                error: function(data) {
                    printErrorMsg(data.responseJSON.message[0]);
                    $('#register-loading').hide();
                    $('#register-form').show();
                    toastr.error(data.responseJSON.message ||
                        "{{ __('An error occurred') }}");
                },
                complete: function() {
                    $('#register-loading').hide();
                    $('#register-form').show();
                    $('#google-login').show();
                },
                success: function(data) {
                    window.location.href = data.url;
                }
            });

            function printErrorMsg(msg) {
                $.each(errors, function(index, value) {
                    $('.' + value.field + '_err').html(value.messages);
                });
            }
        });
        $(document).on('click', '#btn-verification', function(e) {
            e.preventDefault();
            var formData = new FormData($('#verification-form')[0]);
            $.ajax({
                type: 'post',
                enctype: "multipart/form-data",
                url: "{{ route('verification-verify') }}",
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $('#verification-loading').show();
                    $('#verification-form').hide();
                },
                error: function(data) {
                    $('#verification-loading').hide();
                    $('#verification-form').show();
                    if (data.status == 422) {
                        printErrorMsgVerify(data.responseJSON.message[0]);
                    } else {
                        toastr.error(
                            data.responseJSON.message ||
                            "{{ __('An error occurred') }}"
                        );
                    }
                },
                complete: function() {
                    $('#verification-loading').hide();
                    $('#verification-form').show();
                },
                success: function(data) {
                    window.location.href = data.url;
                }
            });

            function printErrorMsgVerify(errors) {
                $.each(errors, function(index, value) {
                    $('.' + value.field + '_err').html(value.messages);
                });
            }
        });
        $(document).on('click', '#btn-login', function(e) {
            e.preventDefault();
            var formData = new FormData($('#login-form')[0]);
            $.ajax({
                type: 'post',
                enctype: "multipart/form-data",
                url: "{{ route('client-login') }}",
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $('#login-loading').show();
                    $('#login-form').hide();
                    $('#google-login').hide();
                    $('#forget-password').hide();
                },
                error: function(data) {
                    $('#login-loading').hide();
                    $('#login-form').show();
                    if (data.status === 422) {
                        printErrorMsgLogin(data.responseJSON.message[0]);
                    } else {
                        toastr.error(
                            data.responseJSON.message ||
                            "{{ __('An error occurred') }}"
                        );
                    }
                },
                complete: function() {
                    $('#login-loading').hide();
                    $('#login-form').show();
                    $('#google-login').show();
                    $('#forget-password').show();
                },
                success: function(data) {
                    window.location.href = data.url;
                }
            });

            function printErrorMsgLogin(errors) {
                $.each(errors, function(index, value) {
                    $('.' + value.field + '_err').html(value.messages);
                });
            }
        });
        $(document).on('click', '#btn-send-email', function(e) {
            e.preventDefault();
            var formData = new FormData($('#send-email-form')[0]);
            $.ajax({
                type: 'post',
                enctype: "multipart/form-data",
                url: "{{ route('client-forget-password') }}",
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $('#send-email-loading').show();
                    $('#send-email-form').hide();
                },
                error: function(data) {
                    if (data.status == 422) {
                        $.each(data.responseJSON.message[0], function(key, value) {
                            $('.' + value.field + '_forget_err').text(value
                                .messages);
                        });
                    } else {
                        toastr.error(
                            data.responseJSON.message ||
                            "{{ __('An error occurred') }}"
                        );
                    }
                    $('#send-email-loading').hide();
                    $('#send-email-form').show();
                },
                success: function(data) {
                    toastr.success(data.message);
                    $('#forget_password_box').hide();
                    $('#verify_email_box').show();
                    $('#ui-filters-login-register').hide();
                    $('#login_box, #register_box').hide();
                    startVerificationTimerInForgetPassword(data.timer);
                }
            });
        });
        $(document).on('click', '#btn-verify-email', function(e) {
            e.preventDefault();
            var formData = new FormData($('#verfiy-email-code-form')[0]);
            $.ajax({
                type: 'post',
                enctype: "multipart/form-data",
                url: "{{ route('client-verify-code') }}",
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $('#verify-email-loading').show();
                    $('#verfiy-email-code-form').hide();
                },
                error: function(data) {
                    if (data.status == 422) {
                        printErrorMsgVerify(data.responseJSON.message[0]);
                    } else {
                        toastr.error(
                            data.responseJSON.message ||
                            "{{ __('An error occurred') }}"
                        );
                    }
                    $('#verfiy-email-code-loading').hide();
                    $('#verfiy-email-code-form').show();
                },
                success: function(data) {
                    toastr.success(data.message);
                    $('#verify_email_box').hide();
                    $('#reset_password_box').show();
                    $('#ui-filters-login-register').hide();
                    $('#login_box, #register_box').hide();
                }
            });

            function printErrorMsgVerify(msg) {
                $.each(msg, function(key, value) {
                    $('.' + key + '_err').text(value);
                });
            }
        });
        $(document).on('click', '#btn-reset-password', function(e) {
            e.preventDefault();
            var formData = new FormData($('#reset-password-form')[0]);
            $.ajax({
                type: 'post',
                enctype: "multipart/form-data",
                url: "{{ route('client-reset-password') }}",
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $('#reset-password-loading').show();
                    $('#reset-password-form').hide();
                },
                error: function(data) {
                    if (data.status == 422) {
                        printErrorMsgReset(data.responseJSON.message[0]);
                    } else {
                        toastr.error(
                            data.responseJSON.message ||
                            "{{ __('An error occurred') }}"
                        );
                    }
                    $('#reset-password-loading').hide();
                    $('#reset-password-form').show();
                    toastr.error(data.responseJSON.message ||
                        "{{ __('An error occurred') }}");
                },
                complete: function() {
                    $('#reset_password_box').hide();
                    $('#login_box').show();
                    $('#ui-filters-login-register').hide();
                    $('#register_box').hide();
                },
                success: function(data) {
                    window.location.href = data.url;
                }
            });

            function printErrorMsgReset(msg) {
                $.each(msg, function(key, value) {
                    $('.' + key + '_err').text(value);
                });
            }
        });
    });
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
                window.location.href = "{{ route('client-logout') }}";
            }
        });
    }
</script>
@if (request()->has('is_verify') &&
        request('is_verify') == 0 &&
        session()->has('verification-timer') &&
        (auth()->check() && !auth()->user()->email_verified_at))
    <script>
        $('#verificationModal').modal('show');
    </script>
@endif
<script>
    function startVerificationTimer(expiresAt) {
        const timerElement = $('#verification-countdown');

        const endTime = new Date(expiresAt).getTime();

        const interval = setInterval(() => {
            const remaining = endTime - Date.now();

            if (remaining <= 0) {
                clearInterval(interval);
                $('#verification-form-container').hide();
                $('#verification-resend-container').show();
                return;
            }
            const totalSeconds = Math.floor(remaining / 1000);

            const minutes = Math.floor(totalSeconds / 60);
            const seconds = totalSeconds % 60;

            timerElement.text(
                `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`
            );
        }, 1000);
    }
    startVerificationTimer(
        "{{ session()->get('verification-timer') }}",
    );
</script>
<script>
    function resendCode() {
        $.ajax({
            type: 'get',
            url: "{{ route('verification-resend') }}",
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,

            beforeSend: function() {
                $('#resend-loading').show();
                $('#resend-code').hide();
            },

            error: function(data) {
                toastr.error(
                    data.responseJSON.message ||
                    "{{ __('An error occurred') }}"
                );
            },

            complete: function() {
                $('#resend-loading').hide();
                $('#resend-code').show();
            },

            success: function(data) {
                toastr.success(data.message);

                $('#verification-form-container').show();
                $('#verification-resend-container').hide();

                startVerificationTimer(data.timer);
            }
        });
    }
</script>
<script>
    function startVerificationTimerInForgetPassword(minutes) {

        const timerElement = $('#forget-countdown');

        const endTime = new Date(minutes).getTime();

        const interval = setInterval(() => {
            const remaining = endTime - Date.now();

            if (remaining <= 0) {
                clearInterval(interval);
                ('#verify_email_box').hide();
                $('#forget_password_box').show();
                return;
            }
            const totalSeconds = Math.floor(remaining / 1000);

            const minutes = Math.floor(totalSeconds / 60);
            const seconds = totalSeconds % 60;

            timerElement.text(
                `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`
            );
        }, 1000);
    }
</script>
<script>
    function startVerificationTimerAll(id, endTime, callback) {

    const timerElement = $('#' + id);
    const endTimestamp = new Date(endTime).getTime();

    const interval = setInterval(() => {

        const remaining = endTimestamp - Date.now();

        if (remaining <= 0) {

            clearInterval(interval);

            if (callback) {
                callback();
            }

            return;
        }

        const totalSeconds = Math.floor(remaining / 1000);
        const minutes = Math.floor(totalSeconds / 60);
        const seconds = totalSeconds % 60;

        timerElement.text(
            `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`
        );

    }, 1000);
}
</script>
