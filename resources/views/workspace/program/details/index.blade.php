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
                        <h1>
                            <i class="fas fa-tv"></i>
                            {{ __('Program Details') }}
                        </h1>
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
            <br>
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header p-2">
                        <ul class="nav nav-pills">

                            <li class="nav-item">
                                <a class="nav-link active" href="#episodes" data-toggle="tab">

                                    {{ __('Episodes') }}

                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#program-team" data-toggle="tab">

                                    {{ __('Program Team') }}

                                </a>
                            </li>

                        </ul>
                    </div>

                    <div class="card-body tab-content">

                        {{-- Episodes --}}
                        <div class="tab-pane fade show active" id="episodes">

                            <section class="content">
                                <div class="error-page">

                                    <div class="error-content">

                                        <h1>
                                            <i class="fas fa-film text-warning-matla"></i>
                                            {{ __('No Episodes Found') }}
                                        </h1>

                                        <button class="btn btn-matla">
                                            {{ __('Add Episode') }}
                                        </button>

                                    </div>

                                </div>
                            </section>

                        </div>

                        {{-- Program Team --}}
                        <div class="tab-pane fade" id="program-team">

                            <div class="table-responsive p-0">

                                <table class="table table-hover text-nowrap">

                                    <thead class="table-matla">
                                        <tr>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('The Role') }}</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($program->teamMembers as $teamMember)
                                            <tr data-id="{{ $teamMember->id }}">
                                                <td>
                                                    <img alt="Avatar" class="table-avatar-matla"
                                                        src="{{ asset('public/img/da7ed7b0-5f66-4f97-a610-51100d3b9fd2.jpg') }}">

                                                    {{ $teamMember->name }}
                                                </td>

                                                <td>{{ $teamMember->role->name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </main>
    </div> <!-- End content-wrapper -->
@endsection
