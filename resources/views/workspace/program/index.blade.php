@extends('workspace.layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('public/css/program.css') }}">
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-header matla-programs-header">
            <div class="container-fluid">
                <div class="matla-programs-heading">
                    <div>
                        <h1 class="m-0"><i class="fas fa-tv"></i> {{ __('Programs') }}</h1>
                        <p>{{ __('Manage channel programs, broadcast schedules and teams.') }}</p>
                    </div>
                    @if (auth()->guard('member')->user()->hasPermission('add-program'))
                        <button type="button" class="btn btn-matla matla-add-program" data-toggle="modal"
                            data-target="#add-program">
                            <i class="fas fa-plus"></i> {{ __('Add Program') }}
                        </button>
                    @endif
                </div>
            </div>
        </div>
        @include('workspace.program.all')
    </div>
    @include('workspace.program.create')
@endsection

@section('script')
    @include('workspace.program.script')
@endsection
