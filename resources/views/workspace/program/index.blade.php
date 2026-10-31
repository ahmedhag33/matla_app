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
                        <button type="button" class="btn btn-matla" data-toggle="modal" data-target="#add-program">
                            {{ __('Add Program') }}
                        </button>
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
                                                <div class="col-auto program-actions">
                                                    <button class="btn btn-matla">
                                                        {{ __('Manage Episodes') }}
                                                    </button>
                                                </div>
                                                <div class="col px-4 program-info">
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
                                                    <div class="program-details">
                                                        <span>{{ $program->broadcast_schedule_attribute }}</span>
                                                        <span>{{ $program->duration_attribute }}</span>
                                                        <span>0</span>
                                                    </div>

                                                </div>
                                                <div class="col-auto">
                                                    <img class="img-fluid program-image"
                                                        src="{{ asset('public/img/program.png') }}" alt="Program">
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
