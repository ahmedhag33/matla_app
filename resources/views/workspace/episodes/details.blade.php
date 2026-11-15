@extends('workspace.layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('public/dashboard/dist/css/episode.css') }}">
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>
                            <i class="fas fa-film"></i>
                            {{ __('Episode Details') }}
                        </h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        @include('workspace.episodes.all')
    </div> <!-- End content-wrapper -->
    @include('workspace.episodes.create')
@endsection
@section('script')
    @if (session()->has('success-message-segment'))
        <script>
            toastr.success("{{ session('success-message-segment') }}");
        </script>
    @endif
    <script>
        $(document).ready(function() {
            $(document).on('click', '.btn-segment', function(e) {
                e.preventDefault();
                var formData = new FormData($('#addSegmentForm')[0]);
                $.ajax({
                    type: 'post',
                    enctype: "multipart/form-data",
                    url: "{{ routeWorkspace('workspace.segment.create-or-update') }}",
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function() {
                        $('#segment-loading').show();
                        $('#addSegmentForm').hide();
                    },
                    error: function(data) {
                        $('#segment-loading').hide();
                        $('#addSegmentForm').show();
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
                        $('#segment-loading').hide();
                        $('#addSegmentForm').show();
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
@endsection
