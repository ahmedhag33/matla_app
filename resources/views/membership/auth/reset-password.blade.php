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
                <p class="login-box-msg" style="font-weight: bold;">{{ __('Reset password') }}</p>
                <form id="reset-form">
                    @csrf
                    <div class="input-group mb-3 position-relative">
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="{{ __('New Password') }}">
                        <span class="text-danger password_err"></span>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>

                        <img src="{{ asset('public/img/eye-solid-full.svg') }}" id="togglePassword" alt="Show password"
                            class="show-password">
                    </div>
                    <span class="text-danger password_err"></span>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="strong_password">
                            <label class="custom-control-label" for="strong_password">
                                {{ __('Create a Strong Password') }}
                            </label>
                        </div>
                    </div>
                    <div class="input-group mb-3 position-relative">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-control" placeholder="{{ __('Confirm Password') }}">
                        <span class="text-danger password_confirmation_err"></span>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <img src="{{ asset('public/img/eye-solid-full.svg') }}" id="toggle-confirmPassword"
                            alt="Show confirm password" class="show-password">
                    </div>
                    <span class="text-danger password_confirmation_err"></span>
                    <!-- /.col -->
                    <div class="row">
                        <div class="col-12">
                            <button type="submit"
                                class="btn btn-matla btn-reset">{{ __('Confirm') }}</button>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.col -->
                </form>
                <div id="reset-loading" class="spinner-grow text-dark" role="status" style="display: none;">
                    <span class="sr-only">Loading...</span>
                </div>
                <br>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    @include('membership.layouts.script')
    <script>
        $(document).ready(function() {
            $('.role').select2();
            $('#strong_password').change(function() {
                var password = "{{ passwordGenerator() }}";
                if ($(this).is(':checked')) {
                    $('#password').val(password);
                    $('#password_confirmation').val(password);
                } else {
                    $('#password').val('');
                    $('#password_confirmation').val('');
                }
            });
            togglePasswordVisibility('password', 'togglePassword');

            togglePasswordVisibility('password_confirmation', 'toggle-confirmPassword');

            $(document).on('click', '.btn-reset', function(e) {
                e.preventDefault();
                var formData = new FormData($('#reset-form')[0]);
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
                        $('#register-loading').hide();
                        $('#register-form').show();
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
                        $('#register-loading').hide();
                        $('#register-form').show();
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
