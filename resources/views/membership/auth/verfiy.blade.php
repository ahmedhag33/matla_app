<!DOCTYPE html>
@if (getCurrentLanguage() == 'ar')
    <html lang="ar" dir="rtl">
@else
    <html lang="en">
@endif

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>

    <!-- Google Font: Source Sans Pro -->
    @include('membership.layouts.link')
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <img src="{{ asset('public/img/matla_logo_in_workspace_side.png') }}" alt="Matla" height="100">
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg" style="font-weight: bold;">
                    {{ __('A verification code has been sent to your email, please enter it.') }}</p>
                <form id="verification-form">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="verification_code"
                            placeholder="{{ __('Verification code') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-matla btn-verification">{{ __('Verify') }}</button>
                        </div>
                        <!-- /.col -->
                    </div>
                    <span id="verification-timer">
                        <b>{{ __('Verification Code Expired In') }}</b>
                        <span id="verification-countdown"></span>
                    </span>
                    <!-- /.col -->
                </form>
                <div class="card-body" id="resend-code">
                    <button type="button" class="btn btn-light"
                        onclick="resendCode();">{{ __('Resend Verification Code') }}</button>
                </div>
                <div id="resend-loading" class="spinner-grow text-dark" role="status" style="display: none;">
                    <span class="sr-only">Loading...</span>
                </div>
                <div id="verification-loading" class="spinner-grow text-dark" role="status" style="display: none;">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    @include('membership.layouts.script')
    <script>
        function resendCode() {
            $.ajax({
                type: 'get',
                url: "{{ route('workspace.verification.resend') }}",
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

                    $('#verification-form').show();
                    $('#resend-code').hide();

                    startVerificationTimer(data.timer);
                }
            });
        }
    </script>
    <script>
        function startVerificationTimer(expiresAt) {
            const timerElement = $('#verification-countdown');

            const endTime = new Date(expiresAt).getTime();

            const interval = setInterval(() => {
                const remaining = endTime - Date.now();

                if (remaining <= 0) {
                    clearInterval(interval);
                    $('#verification-form').hide();
                    $('#resend-code').show();
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
        $(document).ready(function() {
            $(document).on('click', '.btn-verification', function(e) {
                e.preventDefault();
                var formData = new FormData($('#verification-form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: "multipart/form-data",
                    url: "{{ route('workspace.verification.verify') }}",
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function() {
                        $('#register-loading').show();
                        $('#register-form').hide();
                    },
                    error: function(data) {
                        $('#verification-loading').hide();
                        $('#verification-form').show();
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
                        $('#verification-loading').hide();
                        $('#verification-form').show();
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
        });
    </script>
</body>

</html>
