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
                            <i class="fas fa-tasks"></i>
                            {{ __('My Tasks') }}
                        </h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <main class="matla-program-details">
            <section class="matla-program-content">
                <div class="matla-tabs-header">
                    <ul class="nav nav-pills matla-program-tabs" role="tablist">
                        <li class="nav-item"><a class="nav-link active" href="#calendar" data-toggle="tab" role="tab"><i
                                    class="fas fa-calendar"></i>{{ __('Calendar') }}</a></li>
                        <li class="nav-item"><a class="nav-link" href="#task-list" data-toggle="tab" role="tab"><i
                                    class="fas fa-list"></i>{{ __('Task List') }}</a></li>
                    </ul>
                </div>
                <div class="tab-content matla-program-tab-content">
                    <div class="tab-pane fade show active" id="calendar" role="tabpanel">
                        <h1>{{ __('Calendar') }}</h1>
                    </div>
                    <div class="tab-pane fade" id="task-list" role="tabpanel">
                        <h1>{{ __('Task List') }}</h1>
                    </div>
                </div>
            </section>
        </main>
    </div> <!-- End content-wrapper -->
@endsection
