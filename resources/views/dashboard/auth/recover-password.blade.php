<!DOCTYPE html>
@if (getCurrentLanguage() == 'ar')
    <html lang="ar" dir="rtl">
@else
    <html lang="en">
@endif

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Trial Version') }}</title>

    @include('dashboard.layouts.link')
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="">{{ __('Trial Version') }}</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">{{ __('You must change your password before continuing') }}</p>
                </p>
                <form id="update-password-form">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="password" name="old_password" id="old_password" class="form-control"
                            placeholder="{{ __('Password') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <img src="{{ asset('public/img/eye-solid-full.svg') }}" id="showOldPassword" alt="showOldPassword"
                        style="
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            cursor: pointer;
            z-index: 10;
        ">
                    <div class="input-group mb-3">
                        <input type="password" name="new_password" id="new_password" class="form-control"
                            placeholder="{{ __('Confirm Password') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <img src="{{ asset('public/img/eye-solid-full.svg') }}" id="showNewPassword" alt="showNewPassword"
                        style="
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            cursor: pointer;
            z-index: 10;
        ">
                    <div class="row">
                        <div class="col-12">
                            <button type="submit"
                                class="btn btn-primary btn-update-password">{{ __('Change Password') }}</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <div id="update-password-loading" class="spinner-grow text-dark" role="status" style="display: none;">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    @include('dashboard.layouts.script')
    @if (session()->has('error-admin-password-not-change'))
        <script>
            toastr.error("{{ session()->get('error-admin-password-not-change') }}");
        </script>
    @endif
    <script>
        $(document).ready(function() {
            $('#showOldPassword').on('click', function() {
                const old_password = $('#old_password');
                if (old_password.attr('type') === 'password') {
                    old_password.attr('type', 'text');
                    $(this).attr(
                        'src',
                        "{{ asset('public/img/eye-slash-solid-full.svg') }}"
                    );
                } else {
                    old_password.attr('type', 'password');

                    $(this).attr(
                        'src',
                        "{{ asset('public/img/eye-solid-full.svg') }}"
                    );
                }
            });
            $('#showNewPassword').on('click', function() {
                const new_password = $('#new_password');
                if (new_password.attr('type') === 'password') {
                    new_password.attr('type', 'text');
                    $(this).attr(
                        'src',
                        "{{ asset('public/img/eye-slash-solid-full.svg') }}"
                    );
                } else {
                    new_password.attr('type', 'password');

                    $(this).attr(
                        'src',
                        "{{ asset('public/img/eye-solid-full.svg') }}"
                    );
                }
            });
            $(document).on('click', '.btn-update-password', function(e) {
                e.preventDefault();
                var formData = new FormData($('#update-password-form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: "multipart/form-data",
                    url: "{{ route('dashboard.auth.recover-password.post') }}",
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function() {
                        $('#update-password-loading').show();
                        $('#update-password-form').hide();
                    },
                    error: function(data) {
                        if (data.status == 422) {
                            printErrorMsgUpdatePassword(data.responseJSON.message[0]);
                        } else {
                            toastr.error(
                                data.responseJSON.message ||
                                "{{ __('An error occurred') }}"
                            );
                        }
                        $('#update-password-loading').hide();
                        $('#update-password-form').show();
                    },
                    complete: function() {
                        $('#update-password-loading').hide();
                        $('#update-password-form').show();
                    },
                    success: function(data) {
                        window.location.href = data.url;
                    }
                });

                function printErrorMsgUpdatePassword(msg) {
                    $.each(msg, function(key, value) {
                        $('.' + key + '_err').text(value);
                    });
                }
            });
        });
    </script>
</body>

</html>
