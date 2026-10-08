@extends('client.layouts.app')

@section('content')
    <section style="background-color: #eee;">
        <div class="container py-5">
            <div class="row">

                {{-- Profile Card --}}
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            @if (!auth()->user()->photo)
                                <img src="{{ asset('public/img/da7ed7b0-5f66-4f97-a610-51100d3b9fd2.jpg') }}" alt="avatar"
                                    class="rounded-circle img-fluid" style="width: 150px;">
                            @else
                                <img src="{{ asset('public/client/img/' . auth()->user()->photo) }}" alt="avatar"
                                    class="rounded-circle img-fluid" style="width: 150px;">
                            @endif

                            <h5 class="my-3">{{ auth()->user()->name }}</h5>

                            <div class="d-flex justify-content-center mb-2">
                                <button type="button" data-mdb-button-init data-mdb-ripple-init
                                    class="btn btn-outline-primary ms-1" data-toggle="modal"
                                    data-target="#update-photo-model">
                                    {{ __('Edit Image') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- User Information --}}
                <div class="col-lg-8">

                    {{-- Name --}}
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">{{ __('Name') }}</p>
                                </div>

                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">
                                        {{ auth()->user()->name }}
                                    </p>
                                </div>
                                <hr>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">
                                        <button type="button" data-mdb-button-init data-mdb-ripple-init
                                            class="btn btn-outline-dark ms-1" data-toggle="modal"
                                            data-target="#update-profile-model">
                                            <img width="20" height="20"
                                                src="{{ asset('public/img/pen-to-square-solid-full.svg') }}"
                                                alt="author" />
                                        </button>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">{{ __('The Email') }}</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">
                                        {{ auth()->user()->email }}
                                    </p>
                                </div>
                                <hr>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">
                                        <button type="button" data-mdb-button-init data-mdb-ripple-init
                                            class="btn btn-outline-dark ms-1" data-toggle="modal"
                                            data-target="#update-email-model">
                                            <img width="20" height="20"
                                                src="{{ asset('public/img/pen-to-square-solid-full.svg') }}"
                                                alt="author" />
                                        </button>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0"> {{ __('Update Password') }}</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">
                                        <button type="button" data-mdb-button-init data-mdb-ripple-init
                                            class="btn btn-outline-dark ms-1" data-toggle="modal"
                                            data-target="#update-password-model">
                                            <img width="20" height="20"
                                                src="{{ asset('public/img/pen-to-square-solid-full.svg') }}"
                                                alt="author" />
                                        </button>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>
    @include('client.user.edit-photo')
    @include('client.user.edit-profile')
    @include('client.user.edit-email')
    @include('client.user.edit-password')
@endsection
@section('script')
    @include('client.layouts.script-custom')
    @if (session()->has('update-photo-message'))
        <script>
            toastr.success("{{ session()->get('update-photo-message') }}");
        </script>
    @endif
    @if (session()->has('update-profile-message'))
        <script>
            toastr.success("{{ session()->get('update-profile-message') }}");
        </script>
    @endif
    @if (session()->has('success-update-email'))
        <script>
            toastr.success("{{ session()->get('success-update-email') }}");
        </script>
    @endif
    @if (session()->has('update-password-success-message'))
        <script>
            toastr.success("{{ session()->get('update-password-success-message') }}");
        </script>
    @endif
    <script>
        $('#update_old_check').click(function() {
            $(this).is(':checked') ? $('#update_old_password').attr('type', 'text') : $('#update_old_password').attr(
                'type', 'password');
        });
        $('#update_new_check').click(function() {
            $(this).is(':checked') ? $('#update_new_password').attr('type', 'text') : $('#update_new_password').attr(
                'type', 'password');
        });
        $(document).on('click', '#btn-update-photo', function(e) {
            e.preventDefault();
            var formData = new FormData($('#update-photo-form')[0]);
            $.ajax({
                type: 'post',
                enctype: "multipart/form-data",
                url: "{{ route('user.update-photo') }}",
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $('#update-photo-loading').show();
                    $('#update-photo-form').hide();
                },
                error: function(data) {
                    if (data.status == 422) {
                        printErrorUpdatePhotoMsg(data.responseJSON.message[0]);
                    } else {
                        toastr.error(
                            data.responseJSON.message ||
                            "{{ __('An error occurred') }}"
                        );
                    }
                    $('#update-photo-loading').hide();
                    $('#update-photo-form').show();
                },
                complete: function() {
                    $('#update-photo-loading').hide();
                    $('#update-photo-form').show();
                },
                success: function(data) {
                    window.location.href = data.url;
                }
            });

            function printErrorUpdatePhotoMsg(msg) {
                $.each(msg, function(key, value) {
                    $('.' + key + '_err').text(value);
                });
            }
        });
        $(document).on('click', '#btn-update-email', function(e) {
            e.preventDefault();
            var formData = new FormData($('#update-email-form')[0]);
            $.ajax({
                type: 'post',
                enctype: "multipart/form-data",
                url: "{{ route('user.edit-email') }}",
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $('#update-email-loading').show();
                    $('#update-email-form').hide();
                },
                error: function(data) {
                    if (data.status == 422) {
                        printErrorUpdateEmailMsg(data.responseJSON.message[0]);
                    } else {
                        toastr.error(
                            data.responseJSON.message ||
                            "{{ __('An error occurred') }}"
                        );
                    }
                    $('#update-email-loading').hide();
                    $('#update-email-form').show();
                },
                success: function(data) {
                    $('#update-email-form').hide();
                    $('#verfiy-update-email-code-form').show();
                    startVerificationTimerAll('update-countdown', data.timer, function() {
                        $('#verfiy-update-email-code-form').hide();
                        $('#update-email-form').show();
                    });
                    toastr.success(data.message);
                }
            });

            function printErrorUpdateEmailMsg(msg) {
                $.each(msg, function(key, value) {
                    $('.' + key + '_err').text(value);
                });
            }
        });
        $(document).on('click', '#btn-update-done-email', function(e) {
            e.preventDefault();
            var formData = new FormData($('#verfiy-update-email-code-form')[0]);
            $.ajax({
                type: 'post',
                enctype: "multipart/form-data",
                url: "{{ route('user.update-email') }}",
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $('#update-email-done-loading').show();
                    $('#verfiy-update-email-code-form').hide();
                },
                error: function(data) {
                    if (data.status == 422) {
                        printErrorUpdateEmailDoneMsg(data.responseJSON.message[0]);
                    } else {
                        toastr.error(
                            data.responseJSON.message ||
                            "{{ __('An error occurred') }}"
                        );
                    }
                    $('#update-email-done-loading').hide();
                    $('#verfiy-update-email-code-form').show();
                },
                success: function(data) {
                    window.location.href = data.url;
                }
            });

            function printErrorUpdateEmailDoneMsg(msg) {
                $.each(msg, function(key, value) {
                    $('.' + key + '_err').text(value);
                });
            }
        });
        $(document).on('click', '#btn-update-password', function(e) {
            e.preventDefault();
            var formData = new FormData($('#update-password-form')[0]);
            $.ajax({
                type: 'post',
                enctype: "multipart/form-data",
                url: "{{ route('user.update-password') }}",
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
    </script>
@endsection
