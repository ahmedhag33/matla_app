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
            $(document).on('click', '.btn-get-segment', function(e) {
                e.preventDefault();
                var segmentId = $(this).attr('edit_id');
                $.ajax({
                    type: 'post',
                    url: "{{ routeWorkspace('workspace.segment.get-by-id') }}",
                    data: {
                        segment_id: segmentId,
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#addSegmentForm').find('input[name="title"]').val(data.data.title);
                        $('#addSegmentForm').find('input[name="duration"]').val(data.data
                            .duration);
                        $('#addSegmentForm').find('select[name="type"]').val(data.data.type);
                        $('#addSegmentForm').find('input[name="segment_id"]').val(data.data.id);
                        $('#addSegmentForm').find('textarea[name="description"]').val(data.data
                            .description);
                    },
                    error: function(data) {
                        toastr.error(
                            data.responseJSON.message ||
                            "{{ __('An error occurred') }}"
                        );
                    }
                });
            });
            $(document).on('click', '.delete-segment', function(e) {
                Swal.fire({
                    title: "<b>{{ __('Do you Are Delete') }}</b>",
                    icon: "warning",
                    iconColor: "#17233C",
                    showCancelButton: true,
                    confirmButtonColor: "#17233C",
                    cancelButtonColor: "#F59E0B",
                    confirmButtonText: "{{ __('Delete') }}",
                    cancelButtonText: "{{ __('Cancel') }}"
                }).then((result) => {
                    if (result.isConfirmed) {
                        e.preventDefault();
                        var id = $(this).attr('delete_id');
                        $.ajax({
                            type: 'DELETE',
                            url: "{{ routeWorkspace('workspace.segment.delete') }}",
                            dataType: 'json',
                            data: {
                                _token: "{{ csrf_token() }}",
                                'segment_id': id,
                            },
                            success: function(data) {
                                $(`tr[data-id="${id}"]`).remove();
                                toastr.success(data.message);
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
