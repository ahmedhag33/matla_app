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
