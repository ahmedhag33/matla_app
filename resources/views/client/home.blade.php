@extends('client.layouts.app')

@section('content')
    <header class="bg-gradient text-dark" style="background-color: #ffffff !important;">
        <div class="container px-4 text-center">
            <h1 class="fw-bolder">{{ __('Digital Solution Management for Media Services') }}</h1>
            <p class="lead">{{ __('Digital Solution Management for Different Media Services') }}</p>
            <a class="btn btn-lg text-white" href="#"
                style="background-color: #17233C !important">{{ __('Create Your Media Workspace Now') }}</a>
        </div>
    </header>
    <main class="flex-grow-1">
        <!-- محتوى الصفحة -->
    </main>
    @include('client.layouts.auth')
    @include('client.auth.verfication')
@endsection
@section('script')
    @include('client.layouts.script-custom')
@endsection
