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
                    {{ __('New Membership Invitation') . ' ' . $invention->workspace->name }}</p>
                <form id="register-form">
                    @csrf
                    <div class="form-group">
                        <label for="name">{{ __('Name') }}</label>
                        <p>{{ $invention->name }}</p>
                        <input type="text" name="name" class="form-control" placeholder="{{ __('Name') }}"
                            value="{{ $invention->name }}" hidden>
                    </div>
                    <span class="text-danger name_err"></span>
                    <div class="form-group">
                        <label for="email">{{ __('The Email') }}</label>
                        <p>{{ $invention->email }}</p>
                        <input type="email" name="email" id="email" class="form-control"
                            placeholder="{{ __('The Email') }}" value="{{ $invention->email }}" hidden>
                    </div>
                    <span class="text-danger email_err"></span>
                    <div class="form-group">
                        <label for="role_id">{{ __('The Role') }}</label>
                        <p>{{ $invention->role->name }}</p>
                        <input type="text" name="role_id" id="role_id" class="form-control"
                            value="{{ $invention->workspace_role_id }}" hidden>
                    </div>
                    <span class="text-danger role_id_err"></span>
                    <div class="input-group mb-3 position-relative">
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="{{ __('Password') }}">
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
                                class="btn btn-matla btn-register">{{ __('Create Account') }}</button>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.col -->
                </form>
                <div id="register-loading" class="spinner-grow text-dark" role="status" style="display: none;">
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
                var formData = new FormData($('#register-form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: "multipart/form-data",
                    url: "{{ route('workspace.auth.invention-register.post') }}",
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
                            printError(data.responseJSON.message[0]);
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

                function printError(errors) {
                    $.each(errors, function(index, value) {
                        $('.' + value.field + '_err').html(value.messages);
                    });
                }
            });
        });
    </script>
</body>

</html>
