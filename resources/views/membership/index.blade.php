@extends('membership.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
        </div>
        <!-- /.content-header -->

        <section class="content">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="card card-matla card-outline">
                        <div class="card-header">
                            <h3 class="card-title" style="font-weight: bold;">
                                {{ __('Welcome') . ' ' . auth()->guard('member')->user()->name }}
                            </h3>
                        </div>

                        <div class="card-body">
                            {{ __('My Workspace at the Media') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @if ($inventions->isNotEmpty())
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card card-matla card-outline">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Pending Invitations') }}</h3>
                        </div>
                        <div class="card-body">
                            <!-- we are adding the accordion ID so Bootstrap's collapse plugin detects it -->
                            @foreach ($inventions as $invention)
                                <div id="accordion{{ $invention->id }}">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h4 class="card-title w-100">
                                                <a class="d-block w-100" data-toggle="collapse"
                                                    href="#collapse{{ $invention->id }}">
                                                    {{ $invention->workspace->name }}
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapse{{ $invention->id }}" class="collapse show"
                                            data-parent="#accordion{{ $invention->id }}">
                                            <div class="card-body">
                                                <a href="javascript:void(0);" class="btn btn-matla btn-confirm"
                                                    data-workspace-id="{{ $invention->workspace_id }}">
                                                    {{ __('Accept Invitation') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!-- Main content -->
        <div class="content">
            <div class="container">

                @if (auth()->guard('member')->user()->workspaces()->exists())
                    <div class="row">
                        @php
                            $workspaces = auth()->guard('member')->user()->workspaces()->get();
                        @endphp
                        @foreach ($workspaces as $workspace)
                            <div class="col-lg-6 col-md-6 mb-3">
                                <div class="card card-matla card-outline h-100">
                                    <div class="card-header">
                                        <div class="image">
                                            <img src="{{ asset('public/img/display-solid-full.svg') }}" alt="Members"
                                                width="30">
                                        </div>
                                        <h5 class="card-title m-0" style="font-weight: bold;">{{ $workspace->name }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">{{ __('Media Workspace') }}</p>
                                        <a href="{{ route('workspace.dashboard.index', ['slug' => $workspace->slug]) }}"
                                            class="btn btn-matla">
                                            {{ __('Access Workspace') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <section class="content">
                        <div class="error-page">
                            <div class="error-content">
                                <h3><i
                                        class="fas fa-exclamation-triangle text-warning-matla"></i>{{ __('You have no workspace') }}
                                </h3>
                                @if (auth()->guard('member')->user()->hasPermission('add-workspace'))
                                    <p>
                                        {{ __('Do you want to create a new workspace?') }}
                                    </p>
                                    <a href="{{ route('workspace.create-workspace.index') }}" class="btn btn-matla">
                                        {{ __('Add Workspace') }}
                                    </a>
                                @endif
                            </div>
                            <!-- /.error-content -->
                        </div>
                        <!-- /.error-page -->
                    </section>
                @endif
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('.btn-confirm').on('click', function() {
                Swal.fire({
                    title: "<b>{{ __('Do you want to accept the invitation?') }}</b>",
                    icon: "warning",
                    iconColor: "#17233C",
                    showCancelButton: true,
                    confirmButtonColor: "#17233C",
                    cancelButtonColor: "#F59E0B",
                    confirmButtonText: "{{ __('Accept') }}",
                    cancelButtonText: "{{ __('Cancel') }}"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('workspace.member.accept-invitation') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                workspace_id: $(this).data('workspace-id')
                            },
                            success: function(data) {
                                window.location.href = data.url;
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
