@extends('workspace.layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('public/dashboard/dist/css/episode.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dashboard/dist/css/task.css') }}">
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>
                            <i class="fas fa-tasks"></i>
                            {{ __('Tasks') }}
                        </h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        @include('workspace.tasksManagment.tasks.all')
    </div> <!-- End content-wrapper -->
    @include('workspace.tasksManagment.tasks.create')
@endsection
@section('script')
    <script>
        const $form = $('#add-task-form');
        const panels = ['task-context-part', 'content-type-part', 'content-details-part'];
        document.addEventListener('DOMContentLoaded', function() {
            window.stepper = new Stepper(document.querySelector('.bs-stepper'));
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#description').summernote();
            $('#due_date').datetimepicker({
                format: 'dddd، D MMMM YYYY',
                locale: '{{ app()->getLocale() }}',
                minDate: moment(),
            });
            $('#due_time').datetimepicker({
                format: 'h:mm A',
                locale: '{{ app()->getLocale() }}',
            });
            $('select[name="program_id"]').change(function() {
                var programId = $(this).val();
                // Enable episode select and fetch episodes based on programId
                $.ajax({
                    url: "{{ routeWorkspace('workspace.episode.search') }}",
                    type: 'POST',
                    data: {
                        program_id: programId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        var episodeSelect = $('select[name="episode_id"]');
                        $('option', 'select[name="episode_id"]').text(
                            "{{ __('Select Episode') }}");
                        episodeSelect.prop('disabled', false);
                        episodeSelect.empty();
                        episodeSelect.append(
                            '<option value="">{{ __('Select Episode') }}</option>');
                        $.each(data.episodes, function(key, value) {
                            episodeSelect.append('<option value="' + value.id +
                                '">' +
                                value.title + '</option>');
                        });
                        var memberSelect = $('select[name="assigned_id"]');
                        memberSelect.prop('disabled', false);
                        memberSelect.empty();
                        memberSelect.append(
                            '<option value="">{{ __('Select Member') }}</option>');
                        $.each(data.members, function(key, value) {
                            memberSelect.append('<option value="' + value.id +
                                '">' +
                                value.name + '</option>');
                        });
                    }
                });
            });
            $('select[name="episode_id"]').change(function() {
                var episodeId = $(this).val();
                // Enable segment select and fetch segments based on episodeId
                $.ajax({
                    url: "{{ routeWorkspace('workspace.episode.search-segments') }}",
                    type: 'POST',
                    data: {
                        episode_id: episodeId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        var segmentSelect = $('select[name="segment_id"]');
                        $('option', 'select[name="segment_id"]').text(
                            "{{ __('Select Segment') }}");
                        segmentSelect.prop('disabled', false);
                        segmentSelect.empty();
                        segmentSelect.append(
                            '<option value="">{{ __('Select Segment') }}</option>');
                        $.each(data.segments, function(key, value) {
                            segmentSelect.append('<option value="' + value.id +
                                '">' +
                                value.name + '</option>');
                        });
                    }
                });
            });
            $(document).on('change', 'input[name="task_context"]', function() {
                let isSegment = $(this).val() === 'segment';
                $('.segment-field').toggle(isSegment);
                $('.segment-field select[name="segment_id"]')
                    .prop('disabled', !isSegment);
            });
            // تنفيذ الحالة الافتراضية عند فتح الصفحة
            let isSegmentSelected = $('input[name="task_context"]:checked').val() === 'segment';
            $('.segment-field').toggle(isSegmentSelected);
            $('.segment-field select[name="segment_id"]')
                .prop('disabled', !isSegmentSelected);
            $('.segment-field select[name="segment_id"]').empty();

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
                const step = $(this).data('step');
                console.log(step);
                const $panel = $(this).closest('.content');
                clearErrors();
                $.ajax({
                    url: `/${slug}/workspace/tasks/validate/${step}`,
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
        });
    </script>
@endsection
