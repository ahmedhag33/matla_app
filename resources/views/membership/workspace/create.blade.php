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
                                        <div class="step" data-target="#information-part">
                                            <button type="button" class="step-trigger" role="tab"
                                                aria-controls="information-part" id="information-part-trigger">
                                                <span class="bs-stepper-circle-matla">1</span>
                                                <span class="bs-stepper-label">Various information</span>
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
                                        <div id="information-part" class="content" role="tabpanel"
                                            aria-labelledby="information-part-trigger">
                                            <div class="form-group">
                                                <label for="exampleInputFile">File input</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                            id="exampleInputFile">
                                                        <label class="custom-file-label" for="exampleInputFile">Choose
                                                            file</label>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">Upload</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary" onclick="stepper.previous()">Previous</button>
                                            <button type="submit" class="btn btn-primary">Submit</button>
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
        document.addEventListener('DOMContentLoaded', function() {
            window.stepper = new Stepper(document.querySelector('.bs-stepper'))
        });
    </script>
@endsection
