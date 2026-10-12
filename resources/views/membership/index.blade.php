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
                                {{ __('Welcome') }} Ahmed Khaled
                            </h3>
                        </div>

                        <div class="card-body">
                            {{ __('My Workspace at the Media') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <div class="content">
            <div class="container">

                <div class="row">
                    <div class="col-lg-6 col-md-6 mb-3">
                        <div class="card card-matla card-outline h-100">
                            <div class="card-header">
                                <div class="image">
                                    <img src="{{ asset('public/img/display-solid-full.svg') }}" alt="Members"
                                        width="30">
                                </div>
                                <h5 class="card-title m-0" style="font-weight: bold;">ON Tv Channel</h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">{{ __('Media Workspace') }}</p>
                                <a href="#" class="btn btn-matla">
                                    {{ __('Access Workspace') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 mb-3">
                        <div class="card card-matla card-outline h-100">
                            <div class="card-header">
                                <div class="image">
                                    <img src="{{ asset('public/img/display-solid-full.svg') }}" alt="Members"
                                        width="30">
                                </div>
                                <h5 class="card-title m-0" style="font-weight: bold;">DMC Tv Channel</h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">{{ __('Media Workspace') }}</p>
                                <a href="#" class="btn btn-matla">
                                    {{ __('Access Workspace') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection
