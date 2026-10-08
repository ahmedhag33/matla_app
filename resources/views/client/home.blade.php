@extends('client.layouts.app')

@section('content')
    <header class="bg-gradient text-dark" style="background-color: #ffffff !important;">
        <div class="container px-4 text-center">
            <h1 class="fw-bolder">{{ __('Digital Solution Management for Media Services') }}</h1>
            <p class="lead">{{ __('Digital Solution Management for Different Media Services') }}</p>
            <a class="btn btn-lg text-white" href="#" style="background-color: #17233C !important">{{ __('Create Your Media Workspace Now') }}</a>
        </div>
    </header>
    <!-- About section-->
    <section id="about">
        <div class="container px-4">
            <div class="row gx-4 justify-content-center">
                <div class="col-lg-8">
                    <h2>{{ __('Digital Solution Management for Media Services') }}</h2>
                    <p class="lead">{{ __('Digital Solution Management for Different Media Services') }}</p>
                </div>
            </div>
        </div>
    </section>
    @include('client.layouts.auth')
    @include('client.auth.verfication')
@endsection
@section('script')
    @include('client.layouts.script-custom')
@endsection
