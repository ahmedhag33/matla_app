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
                <p class="login-box-msg" style="font-weight: bold;">{{ __('A verification code has been sent to your email, please enter it.') }}</p>
                <form id="verification-form">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="code" placeholder="{{ __('Verification code') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-matla btn-verification">{{ __('Create Account') }}</button>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.col -->
                </form>
                <div id="verification-loading" class="spinner-grow text-dark" role="status" style="display: none;">
                    <span class="sr-only">Loading...</span>
                </div>
                <br>
                <p class="mb-0">
                    <a href="{{ route('workspace.auth.login') }}" class="text-center"
                        style="color: #17233C;">{{ __('Already have an account ?') }}</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    @include('membership.layouts.script')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.btn-verification', function(e) {
                e.preventDefault();
                var formData = new FormData($('#verification-form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: "multipart/form-data",
                    url: "",
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
