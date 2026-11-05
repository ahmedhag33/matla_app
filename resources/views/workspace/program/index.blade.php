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
        @include('workspace.program.all')
    </div> <!-- /.content-wrapper -->
    @include('workspace.program.create')
@endsection
@section('script')
    @if (session()->has('success-message-presenters'))
        <script>
            toastr.success("{{ session('success-message-presenters') }}");
        </script>
    @endif
    @if (session()->has('add-presenters-success'))
        <script>
            toastr.success("{{ session('add-presenters-success') }}");
        </script>
    @endif
    <script>
        $(document).on('click', '.add-program-providers', function() {
            var presenters = [];
            const programId = $(this).data('select-presenters');
            $('#add-program-providers input[name="person_program_id"]').val(programId);
            $.ajax({
                url: "{{ route('workspace.program.showPresenters', ['slug' => request()->route('slug')]) }}",
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    person_program_id: programId
                },
                success: function(data) {
                    $.each(data.presenters, function(key, value) {
                        presenters.push(String(value.id));
                    });
                    $('#presenters').val(presenters).trigger('change');
                }
            });
        });
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

        function formatPresenter(presenter) {
            if (!presenter.id) {
                return presenter.text;
            }

            const image = $(presenter.element).data('image');

            return $(`
        <span class="d-flex align-items-center">
            <img
                src="${image}"
                alt="${presenter.text}"
                class="rounded-circle mr-2"
                width="35"
                height="35"
                style="object-fit: cover;"
            >
            <span>${presenter.text}</span>
        </span>
    `);
        }

        $('#presenters').select2({
            multiple: true,
            templateResult: formatPresenter,
            templateSelection: formatPresenter,
            escapeMarkup: markup => markup,
            width: '100%'
        });
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
                    var program_type_id = data.program.program_type_id;
                    $('#add-program-form input[name="program_type_id"]').val(program_type_id);
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
    <script>
        $(document).on('click', '.save-program-providers', function(e) {
            e.preventDefault();
            var formData = new FormData($('#add-program-providers-form')[0]);
            $.ajax({
                type: 'post',
                enctype: "multipart/form-data",
                url: "{{ route('workspace.program.add-presenters', ['slug' => request()->route('slug')]) }}",
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $('#add-program-providers-loading').show();
                    $('#add-program-providers-form').hide();
                },
                error: function(data) {
                    $('#add-program-providers-loading').hide();
                    $('#add-program-providers-form').show();
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
                    $('#add-program-providers-loading').hide();
                    $('#add-program-providers-form').show();
                },
                success: function(data) {
                    window.location.href = data.url;
                }
            });

            function printError(errors) {
                $.each(errors, function(index, value) {
                    $('#add-program-providers-form .' + value.field + '_err').html(value.messages);
                });
            }
        });
    </script>
@endsection
