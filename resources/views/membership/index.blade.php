@extends('membership.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
        </div>
        <!-- /.content-header -->
        <section class="content">

            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Welcome') }} Ahmed Khaled</h3>
                </div>
                <div class="card-body">
                    {{ __('My Workspace at the Media') }}
                </div>
                <!-- /.card-footer-->
            </div>
            <!-- /.card -->

        </section>
        <!-- Main content -->
        <div class="content">
            <div class="container">

                <div class="row">
                    <div class="col-lg-6 col-md-6 mb-3">
                        <div class="card card-matla card-outline h-100">
                            <div class="card-header">
                                <h5 class="card-title m-0">ON Tv Channel</h5>
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
                                <h5 class="card-title m-0">ON Tv Channel</h5>
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
