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
                <p class="login-box-msg" style="font-weight: bold;">{{ __('Login to Media Workspace') }}</p>
                <form id="login-form">
                    @csrf
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
                    <div class="input-group mb-3 position-relative">
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="{{ __('Password') }}">

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>

                        <img src="{{ asset('public/img/eye-solid-full.svg') }}" id="togglePassword" alt="Show password"
                            class="show-password">
                    </div>
                    <!-- /.col -->
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-matla btn-login">{{ __('Login') }}</button>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.col -->
                </form>
                <div id="login-loading" class="spinner-grow text-dark" role="status" style="display: none;">
                    <span class="sr-only">Loading...</span>
                </div>
                <br>
                <!-- /.social-auth-links -->
                <p class="mb-1">
                    <a href="#" style="color: #17233C;">{{ __('I forgot my password') }}</a>
                </p>
                <p class="mb-0">
                    <a href="{{ route('workspace.auth.register') }}" class="text-center"
                        style="color: #17233C;">{{ __('Register a new membership') }}</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    @include('membership.layouts.script')
    @if (session()->has('error-member-message'))
        <script>
            toastr.error("{{ session()->get('error-member-message') }}");
        </script>
    @endif
    <script>
        $(document).ready(function() {
            togglePasswordVisibility('password', 'togglePassword');
            $(document).on('click', '.btn-login', function(e) {
                e.preventDefault();
                var formData = new FormData($('#login-form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: "multipart/form-data",
                    url: "{{ route('workspace.auth.login.post') }}",
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function() {
                        $('#login-loading').show();
                        $('#login-form').hide();
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
