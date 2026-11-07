@extends('workspace.layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('public/dashboard/dist/css/program.css') }}">
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <main class="main">
            <div class="row">
                <section class="program-card-details">
                    <img src="{{ asset('public/img/program.png') }}" alt="{{ $program->name }}" class="program-logo">
                    <div class="program-description">
                        <h1>{{ $program->name }}</h1>

                        <img src="{{ $program->type->icon_at_full }}" alt="{{ $program->type->name }}" width="20">
                        {{ $program->type->name }}
                        <p>{{ $program->description }}</p>
                    </div>
                    <div class="stats">
                        <div class="stat">
                            <strong>{{ $program->team_members_count }} {{ __('members') }}</strong>
                            <span>{{ __('Program Team') }}</span>
                        </div>
                        <div class="stat">
                            <strong>0</strong>
                            <span>
                                {{ __('Number of Episodes') }}</span>
                        </div>
                        <div class="stat">
                            <strong>{{ $program->default_duration_minutes_to_string }} </strong>
                            <span>{{ __('Episode Duration') }}</span>
                        </div>
                        <div class="stat">
                            <strong>{{ $program->broadcast_schedule_attribute }}</strong>
                            <span>{{ __('Broadcast Schedule') }}</span>
                        </div>
                        <div class="stat">
                            <strong>{!! $program->broadcast_mode_attribute !!}</strong>
                            <span>{{ __('Broadcast Mode') }}</span>
                        </div>
                        <div class="stat">
                            <strong>{{ $program->created_at_formatted }}</strong>
                            <span>{{ __('Created At') }}</span>
                        </div>
                        <div class="stat">
                            <strong>
                                {{ $program->broadcastDays->pluck('day_at_from_enum')->join(' ') }}
                            </strong>
                            <span>{{ __('Day Schedule') }}</span>
                        </div>
                    </div>
                </section>
            </div> <!-- End row -->
        </main>
    </div> <!-- End content-wrapper -->
@endsection
