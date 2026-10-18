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
                <p class="login-box-msg" style="font-weight: bold;">{{ __('Register a new membership') }}</p>
                <form id="register-form">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="name" class="form-control" placeholder="{{ __('Name') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" name="email" id="email" class="form-control"
                            placeholder="{{ __('The Email') }}">
                        <span class="text-danger email_err"></span>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <select class="form-control role" name="role_id" style="width: 100%;">
                            <option value="0" selected="selected">{{ __('The Role') }}</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->slug }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group mb-3 position-relative">
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="{{ __('Password') }}">

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>

                        <img src="{{ asset('public/img/eye-solid-full.svg') }}" id="togglePassword" alt="Show password" class="show-password">
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="strong_password">
                            <label class="custom-control-label" for="strong_password">
                                {{ __('Create a Strong Password') }}
                            </label>
                        </div>
                    </div>
                    <span class="text-danger password_err"></span>

                    <div class="input-group mb-3 position-relative">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-control" placeholder="{{ __('Confirm Password') }}">

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>

                        <img src="{{ asset('public/img/eye-solid-full.svg') }}" id="toggle-confirmPassword"
                            alt="Show confirm password" class="show-password">
                    </div>

                    <!-- /.col -->
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-matla btn-register">{{ __('Create Account') }}</button>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.col -->
                </form>
                <div id="register-loading" class="spinner-grow text-dark" role="status" style="display: none;">
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

            $(document).on('click', '.btn-register', function(e) {
                e.preventDefault();
                var formData = new FormData($('#login-form')[0]);
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
