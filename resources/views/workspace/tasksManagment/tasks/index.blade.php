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
        document.addEventListener('DOMContentLoaded', function() {
            window.stepper = new Stepper(document.querySelector('.bs-stepper'));
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#description').summernote();
            $('#air_date').datetimepicker({
                format: 'dddd، D MMMM YYYY',
                locale: '{{ app()->getLocale() }}',
                minDate: moment(),
            });
            $('#air_time').datetimepicker({
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
                        var memberSelect = $('select[name="assigned_to"]');
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
            $(document).on('change', 'input[name="task_scope"]', function() {
                let isSegment = $(this).val() === 'segment';
                $('.segment-field').toggle(isSegment);
                $('.segment-field select[name="segment_id"]')
                    .prop('disabled', !isSegment);
            });
            // تنفيذ الحالة الافتراضية عند فتح الصفحة
            let isSegmentSelected = $('input[name="task_scope"]:checked').val() === 'segment';
            $('.segment-field').toggle(isSegmentSelected);
            $('.segment-field select[name="segment_id"]')
                .prop('disabled', !isSegmentSelected);
            $('.segment-field select[name="segment_id"]').empty();
        });
    </script>
@endsection
