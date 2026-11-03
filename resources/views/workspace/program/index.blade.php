@extends('workspace.layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('public/css/program.css') }}">
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('Programs') }}</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        @if (auth()->guard('member')->user()->hasPermission('add-program'))
                            <button type="button" class="btn btn-matla" data-toggle="modal" data-target="#add-program">
                                <span><i class="fas fa-plus"></i></span>
                            </button>
                        @endif
                    </h3>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row mt-3">
                            <div class="col-md-10 offset-md-1">
                                <div class="list-group">
                                    @forelse ($programs as $program)
                                        <div class="list-group-item program-item">
                                            <div class="row align-items-center">

                                                {{-- Program Actions --}}
                                                <div class="col-auto program-actions">
                                                    <div class="tools">
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-matla">
                                                                <i class="fas fa-cog"></i>
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-default dropdown-toggle dropdown-icon"
                                                                data-toggle="dropdown">
                                                                <span class="sr-only">Toggle Dropdown</span>
                                                            </button>
                                                            <div class="dropdown-menu" role="menu">
                                                                <a class="dropdown-item edit-program"
                                                                    data-edit-program="{{ $program->id }}"
                                                                    href="javascript:void(0)">
                                                                    <i class="fas fa-edit"></i>
                                                                    {{ __('Edit') }}
                                                                </a>
                                                                <a class="dropdown-item"
                                                                    data-delete-program="{{ $program->id }}"
                                                                    href="javascript:void(0)">
                                                                    <i class="fas fa-recycle"></i>
                                                                    {{ __('Delete') }}
                                                                </a>
                                                                <a class="dropdown-item"
                                                                    data-select-presenters="{{ $program->id }}"
                                                                    href="javascript:void(0)">
                                                                    <i class="fas fa-users"></i>
                                                                    {{ __('Select Presenters') }}
                                                                </a>
                                                                <a class="dropdown-item"
                                                                    data-update-status="{{ $program->id }}"
                                                                    href="javascript:void(0)">
                                                                    <i class="fas fa-sync-alt"></i>
                                                                    {{ __('Update Status') }}
                                                                </a>
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('workspace.program.details', [
                                                                        'slug' => request()->route('slug'),
                                                                        'programSlug' => $program->slug,
                                                                    ]) }}">
                                                                    <i class="fas fa-list"></i>
                                                                    {{ __('Manage Episodes') }}</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Program Information --}}
                                                <div class="col program-info px-4">

                                                    {!! $program->status_attribute !!}

                                                    <h3>{{ $program->name }}</h3>

                                                    <span class="program-type">
                                                        <img src="{{ $program->type->icon_at_full }}"
                                                            alt="{{ $program->type->name }}">

                                                        {{ $program->type->name }}
                                                    </span>

                                                    <p class="mb-3">
                                                        {{ $program->description }}
                                                    </p>

                                                    {{-- Broadcast Days --}}
                                                    <div class="mb-3">
                                                        <i class="fas fa-calendar-day"></i>

                                                        @foreach ($program->broadcastDays as $day)
                                                            <span class="badge bg-light">
                                                                {{ $day->day_at_from_enum }}
                                                            </span>
                                                        @endforeach
                                                    </div>

                                                    {{-- Program Details --}}
                                                    <div class="program-details">

                                                        <span>
                                                            <i class="fas fa-calendar-alt"></i>
                                                            {{ $program->broadcast_schedule_attribute }}
                                                        </span>

                                                        <span>
                                                            <i class="far fa-clock"></i>
                                                            {{ $program->default_duration_minutes_to_string }}
                                                        </span>

                                                        <span>
                                                            <i class="fas fa-podcast"></i>
                                                            {!! $program->broadcast_mode_attribute !!}
                                                        </span>

                                                    </div>

                                                </div>

                                                {{-- Program Image --}}
                                                <div class="col-auto">
                                                    <img class="img-fluid program-image"
                                                        src="{{ asset('public/img/program.png') }}"
                                                        alt="{{ $program->name }}">
                                                </div>

                                            </div>
                                        </div>
                                </div>
                            @empty
                                <div class="error-page">

                                    <div class="error-content">
                                        <h3><i class="fas fa-exclamation-triangle text-warning-matla"></i>
                                            {{ __('No Programs Found') }}</h3>
                                    </div>
                                    <!-- /.error-content -->
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
    </div> <!-- /.content-wrapper -->
    @include('workspace.program.create')
@endsection
@section('script')
    @if (session()->has('success-message-program'))
        <script>
            toastr.success("{{ session('success-message-program') }}");
        </script>
    @endif
    <script>
        const $form = $('#add-program-form');
        const panels = ['information-part', 'program-providers-part', 'duration-and-broadcast-part'];

        document.addEventListener('DOMContentLoaded', function() {
            window.stepper = new Stepper(document.querySelector('.bs-stepper'))
        });
        $(document).on('click', '.program-type-card', function() {
            // إزالة التحديد من كل الكروت
            $('.program-type-card').removeClass('selected');
            // تحديد الكارت الذي ضغط عليه المستخدم
            $(this).addClass('selected');
            // الحصول على ID النوع المختار
            let programTypeId = $(this).data('program-type');
            // تخزينه في الـ hidden input
            $('#program_type_id').val(programTypeId);

        });
        $('.select-presenters').select2();
        $('.select-days-of-the-week').select2();
        $('.program-type-card').on('click', function() {
            $('.program-type-card').removeClass('active');
            $(this).addClass('active');
            $('#program_type_id').val($(this).data('program-type'));
            $('[data-error="program_type_id"]').text('');
        });

        function clearErrors() {
            $('.alert-fallback').remove();
            $('[data-error]').text('');
        }

        function normalizeErrors(json) {
            const out = {};
            (function walk(node) {
                if (Array.isArray(node)) {
                    node.forEach(walk);
                } else if (node && typeof node === 'object') {
                    if ('field' in node && 'messages' in node) {
                        out[node.field] = [].concat(node.messages);
                    } else {
                        $.each(node, function(key, value) {
                            if (Array.isArray(value) && value.length && value.every(v =>
                                    typeof v === 'string')) {
                                out[key] = value;
                            } else {
                                walk(value);
                            }
                        });
                    }
                }
            })(json);
            return out;
        }

        function showErrors(errors) {
            let firstStep = null;

            $.each(errors, function(field, msgs) {
                const html = [].concat(msgs).join('<br>');
                const $span = $(`[data-error="${field}"]`);

                if ($span.length) {
                    $span.html(html);
                } else {
                    $('.bs-stepper-content .content.active')
                        .prepend(`<div class="alert alert-danger alert-fallback">${html}</div>`);
                }

                const panelId = $(`[name="${field}"]`).closest('.content').attr('id');
                const idx = panels.indexOf(panelId);
                if (idx !== -1 && (firstStep === null || idx < firstStep)) firstStep = idx;
            });

            return firstStep;
        }

        function handleFail(xhr) {
            const errors = normalizeErrors(xhr.responseJSON);

            if ($.isEmptyObject(errors)) {
                const msg = (xhr.responseJSON && xhr.responseJSON.message) || 'حصل خطأ، حاول تاني';
                $('.bs-stepper-content .content.active')
                    .prepend(`<div class="alert alert-danger alert-fallback">${msg}</div>`);
                return null;
            }

            return showErrors(errors);
        }
        $('.btn-next-step').on('click', function() {
            var slug = "{{ current_Workspace()->slug }}"
            const step = parseInt($(this).data('step'));
            const $panel = $(this).closest('.content');
            clearErrors();

            $.ajax({
                url: `/${slug}/workspace/programs/validate/${step}`,
                method: 'POST',
                data: $panel.find(':input').serialize() +
                    '&_token=' + encodeURIComponent($form.find('input[name="_token"]').val()),
                headers: {
                    'Accept': 'application/json'
                },
                success: () => stepper.next(),
                error: (xhr) => handleFail(xhr)
            });
        });
        $(document).on('click', '.btn-save', function(e) {
            e.preventDefault();
            var formData = new FormData($($form)[0]);
            $.ajax({
                type: 'post',
                enctype: "multipart/form-data",
                url: "{{ route('workspace.program.create', ['slug' => request()->route('slug')]) }}",
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $('#add-program-loading').show();
                    $form.hide();
                },
                error: function(data) {
                    $('#add-program-loading').hide();
                    $form.show();
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
                    $('#add-program-loading').hide();
                    $form.show();
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
        $(document).on('click', '.edit-program', function() {
            var programId = $(this).data('edit-program');
            var slug = "{{ current_Workspace()->slug }}";
            var arr = [];
            $.ajax({
                url: "{{ route('workspace.program.get-by-id', ['slug' => request()->route('slug')]) }}",
                method: 'POST',
                data: {
                    program_id: programId,
                    _token: "{{ csrf_token() }}"
                },
                headers: {
                    'Accept': 'application/json'
                },
                success: function(data) {
                    $('#add-program').modal('show');
                    $('#add-program-form input[name="program_id"]').val(data.program.id);
                    $('#add-program-form input[name="name"]').val(data.program.name);
                    $('#add-program-form input[name="slug"]').val(data.program.slug);
                    $('#add-program-form textarea[name="description"]').val(data.program.description);
                    var program_type = data.program.program_type_id;
                    var program_id = data.program.id;
                    $('#add-program-form input[name="program_id"]').val(program_id);
                    $('.program-type-card').removeClass('selected');
                    $('.program-type-card[data-program-type="' + program_type + '"]')
                        .addClass('selected');
                    $('#add-program-form input[name="broadcast_schedule"][value="' + data.program
                            .broadcast_schedule + '"]')
                        .prop('checked', true);
                    $('#duration_hours option[value="' + data.program.default_hours + '"]')
                        .prop('selected', true);

                    $('#duration_minutes option[value="' + data.program.default_minutes + '"]')
                        .prop('selected', true);
                    $('#add-program-form input[name="broadcast_mode"][value="' + data.program
                            .broadcast_mode + '"]')
                        .prop('checked', true);
                    $.each(data.program.broadcast_days, function(key, value) {
                        arr.push(String(value.day));
                    });
                    $('.select-days-of-the-week').val(arr).trigger('change');
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON.message || "{{ __('An error occurred') }}");
                }
            });
        });
    </script>
@endsection
