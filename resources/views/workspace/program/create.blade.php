<div class="modal fade" id="add-program">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header-matla">
                <img src="{{ asset('public/img/tv-solid-full.svg') }}" alt="Program Management" style="width: 30px;">

                <h4 class="modal-title">{{ __('Add New Program') }}</h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card-body p-0">

                    <div class="bs-stepper">

                        <!-- Stepper Header -->
                        <div class="bs-stepper-header" role="tablist">

                            <div class="step" data-target="#basic-information-part">
                                <button type="button" class="step-trigger" role="tab"
                                    aria-controls="basic-information-part" id="basic-information-part-trigger">
                                    <span class="bs-stepper-circle-matla">1</span>
                                    <span class="bs-stepper-label">{{ __('Basic Information') }}</span>
                                </button>
                            </div>

                            <div class="line"></div>

                            <div class="step" data-target="#program-providers-part">
                                <button type="button" class="step-trigger" role="tab"
                                    aria-controls="program-providers-part" id="program-providers-part-trigger">
                                    <span class="bs-stepper-circle-matla">2</span>
                                    <span class="bs-stepper-label">{{ __('Program Providers') }}</span>
                                </button>
                            </div>

                            <div class="line"></div>

                            <div class="step" data-target="#duration-and-broadcast-part">
                                <button type="button" class="step-trigger" role="tab"
                                    aria-controls="duration-and-broadcast-part"
                                    id="duration-and-broadcast-part-trigger">
                                    <span class="bs-stepper-circle-matla">3</span>
                                    <span class="bs-stepper-label">{{ __('Duration and Broadcast') }}</span>
                                </button>
                            </div>

                            <div class="line"></div>

                            <div class="step" data-target="#additional-settings-part">
                                <button type="button" class="step-trigger" role="tab"
                                    aria-controls="additional-settings-part" id="additional-settings-part-trigger">
                                    <span class="bs-stepper-circle-matla">4</span>
                                    <span class="bs-stepper-label">{{ __('Additional Settings') }}</span>
                                </button>
                            </div>

                        </div>
                        <!-- End Stepper Header -->

                        <form id="add-program-form">
                            @csrf
                            <input type="hidden" name="program_id" value="">
                            <div class="bs-stepper-content">

                                <!-- Step 1: Basic Information -->
                                @include('workspace.program.information-part')
                                <!-- End Step 1 -->
                                <!-- Step 2: Program Providers -->
                                @include('workspace.program.program-providers')
                                <!-- End Step 2 -->


                                <!-- Step 3: Duration and Broadcast -->
                                @include('workspace.program.duration-and-broadcast')
                                <!-- End Step 3 -->


                                <!-- Step 4: Additional Settings -->
                                @include('workspace.program.additional-settings')
                                <!-- End Stepper Content -->

                        </form>

                    </div>
                    <!-- End Stepper -->

                </div>
            </div>

        </div>
        <!-- End Modal Content -->
    </div>
    <!-- End Modal Dialog -->
</div>
<!-- End Modal -->
