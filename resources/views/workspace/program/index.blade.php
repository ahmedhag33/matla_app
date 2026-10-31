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
            <div class="container-fluid">
                <div class="row mt-3">
                    <div class="col-md-10 offset-md-1">
                        <div class="list-group">
                            <div class="list-group-item program-item">
                                <div class="row align-items-center">

                                    <div class="col-auto program-actions">
                                        <button class="btn btn-matla">▶ إدارة الحلقات</button>
                                    </div>
                                    <div class="col px-4 program-info">
                                        <div class="program-status">نشط</div>
                                        <h3>الكلاسيكو</h3>
                                        <span class="program-type">⚽ رياضي</span>
                                        <p class="mb-3">
                                            برنامج رياضي حواري يتناول أهم أحداث كرة القدم
                                            محلياً وعالمياً.
                                        </p>
                                        <div class="program-details">
                                            <span>📅 كل أسبوع</span>
                                            <span>🕒 01:30 مدة الحلقة</span>
                                            <span>🎬 12 حلقة</span>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <img class="img-fluid program-image" src="{{ asset('public/img/program.png') }}"
                                            alt="صورة البرنامج">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
