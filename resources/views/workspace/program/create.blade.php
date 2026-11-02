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

                            <div class="step" data-target="#duration-and-broadcast-part">
                                <button type="button" class="step-trigger" role="tab"
                                    aria-controls="duration-and-broadcast-part"
                                    id="duration-and-broadcast-part-trigger">
                                    <span class="bs-stepper-circle-matla">2</span>
                                    <span class="bs-stepper-label">{{ __('Duration and Broadcast') }}</span>
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
                                <!-- Step 2: Duration and Broadcast -->
                                @include('workspace.program.duration-and-broadcast')
                                <!-- End Step 2 -->

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
