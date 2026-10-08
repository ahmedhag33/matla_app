@extends('client.layouts.app')

@section('content')
    <header class="bg-primary bg-gradient text-white">
        <div class="container px-4 text-center">
            <h1 class="fw-bolder">{{ __('Welcome To Trial Version') }}</h1>
            <p class="lead">{{ __('Private Content Version To All Projects') }}</p>
        </div>
    </header>
    <!-- About section-->
    <section id="about">
        <div class="container px-4">
            <div class="row gx-4 justify-content-center">
                <div class="col-lg-8">
                    <h2>{{ __('Welcome To Trial Version') }}</h2>
                    <p class="lead">{{ __('Private Content Version To All Projects Description') }}</p>
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
