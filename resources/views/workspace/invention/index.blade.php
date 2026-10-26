@extends('workspace.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('Invite Members') }}</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <button type="button" class="btn btn-matla" data-toggle="modal"
                                        data-target="#add-invention">
                                        {{ __('Add Invitation') }}
                                    </button>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            @if ($inventions->isNotEmpty())
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead class="table-matla">
                                            <tr>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('The Email') }}</th>
                                                <th>{{ __('The Role') }}</th>
                                                <th>{{ __('Invited By') }}</th>
                                                <th>{{ __('Status') }}</th>
                                                <th>{{ __('Invitation Date') }}</th>
                                                <th>{{ __('Invitation Expiration Date') }}</th>
                                                <th>{{ __('Acceptance Date') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($inventions as $invention)
                                                <tr>
                                                    <td>{{ $invention->name }}</td>
                                                    <td>{{ $invention->email }}</td>
                                                    <td>{{ $invention->role->name }}</td>
                                                    <td>{{ $invention->invitedBy->name }}</td>
                                                    <td>{!! $invention->status !!}</td>
                                                    <td>{{ dateformat($invention->created_at) }}</td>
                                                    <td>{{ (is_null($invention->expires_at) ? '-' : dateformat($invention->expires_at)) }}</td>
                                                    <td>{{ (is_null($invention->accepted_at) ? '-' : dateformat($invention->accepted_at)) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="card-body">
                                    <section class="content">
                                        <div class="error-page">

                                            <div class="error-content">
                                                <h3><i class="fas fa-exclamation-triangle text-warning-matla"></i>
                                                    {{ __('No Inventions Found') }}</h3>
                                            </div>
                                            <!-- /.error-content -->
                                        </div>
                                        <!-- /.error-page -->
                                    </section>
                                </div>
                            @endif
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('workspace.invention.create')
@endsection
@section('script')
    @if (session()->has('success-invention'))
        <script>
            toastr.success("{{ session()->get('success-invention') }}");
        </script>
    @endif
    <script>
        $('.role').select2();
    </script>
    <script>
        $(document).on('click', '.btn-send', function(e) {
            e.preventDefault();
            var formData = new FormData($('#add-invention-form')[0]);
            $.ajax({
                type: 'post',
                enctype: "multipart/form-data",
                url: "{{ route('workspace.invention.create', ['slug' => request()->route('slug')]) }}",
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $('#add-invention-loading').show();
                    $('#add-invention-form').hide();
                },
                error: function(data) {
                    $('#add-invention-loading').hide();
                    $('#add-invention-form').show();
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
                    $('#add-invention-loading').hide();
                    $('#add-invention-form').show();
                },
                success: function(data) {
                    window.location.reload();
                }
            });

            function printError(errors) {
                $.each(errors, function(index, value) {
                    $('.' + value.field + '_err').html(value.messages);
                });
            }
        });
    </script>
@endsection
