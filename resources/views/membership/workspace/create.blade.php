@extends('membership.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row col-md-12">
                    <div class="col-md-12">
                        <div class="card card-matla card-outline">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('Ready to build your media workspace') }}</h3>
                            </div>
                            <div class="card-body p-0">
                                <div class="bs-stepper">
                                    <div class="bs-stepper-header" role="tablist">
                                        <div class="step" data-target="#basic-part">
                                            <button type="button" class="step-trigger" role="tab"
                                                aria-controls="basic-part" id="basic-part-trigger">
                                                <span class="bs-stepper-circle-matla">1</span>
                                                <span class="bs-stepper-label">{{ __('Basic Information') }}</span>
                                            </button>
                                        </div>
                                        <div class="line"></div>
                                        <div class="step" data-target="#country-part">
                                            <button type="button" class="step-trigger" role="tab"
                                                aria-controls="country-part" id="country-part-trigger">
                                                <span class="bs-stepper-circle-matla">2</span>
                                                <span class="bs-stepper-label">{{ __('Select Country') }}</span>
                                            </button>
                                        </div>
                                        <div class="line"></div>
                                        <div class="step" data-target="#media-part">
                                            <button type="button" class="step-trigger" role="tab"
                                                aria-controls="media-part" id="media-part-trigger">
                                                <span class="bs-stepper-circle-matla">3</span>
                                                <span class="bs-stepper-label">{{ __('Select Media Activity') }}</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="bs-stepper-content">
                                        <!-- your steps content here -->
                                        <div id="basic-part" class="content" role="tabpanel"
                                            aria-labelledby="basic-part-trigger">
                                            <p>{{ __('Please Define Your Work Area') }}</p>
                                            <div class="form-group col-md-8">
                                                <label for="exampleInputEmail1">{{ __('Workspace Name') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="name" class="form-control"
                                                    id="exampleInputEmail1"
                                                    placeholder="{{ __('Example : Media Workspace') }}">
                                            </div>
                                            <div class="form-group col-md-8">
                                                <label for="inputMessage">{{ __('Workspace Description') }}</label>
                                                <textarea id="description" placeholder="{{ __('Write a short description for your team or job') }}" name="description"
                                                    class="form-control" rows="4"></textarea>
                                            </div>
                                            <button class="btn btn-matla"
                                                onclick="stepper.next()">{{ __('Next') }}</button>
                                        </div>
                                        <div id="country-part" class="content" role="tabpanel"
                                            aria-labelledby="country-part-trigger">
                                            <p>{{ __('Select Workspace Country') }}</p>
                                            <div class="form-group col-md-8">
                                                <label>{{ __('Country') }} <span class="text-danger">*</span></label>
                                                <select name="country_id" class="form-control country" style="width: 100%;">
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button class="btn btn-matla"
                                                onclick="stepper.next()">{{ __('Next') }}</button>
                                            <button class="btn btn-matla"
                                                onclick="stepper.previous()">{{ __('Previous') }}</button>
                                        </div>
                                        <div id="media-part" class="content" role="tabpanel"
                                            aria-labelledby="media-part-trigger">
                                            <button class="btn btn-matla"
                                                onclick="stepper.previous()">{{ __('Previous') }}</button>
                                            <button type="submit" class="btn btn-matla">{{ __('Confirm') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
    <script>
        $('.country').select2();
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.stepper = new Stepper(document.querySelector('.bs-stepper'))
        });
    </script>
@endsection
