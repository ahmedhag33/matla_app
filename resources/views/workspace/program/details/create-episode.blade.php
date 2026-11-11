<div class="modal fade" id="addEpisodeModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header-matla">
                <h4 class="modal-title">
                    <img src="{{ asset('public/img/film-solid-full-white.svg') }}" alt="Program Management"
                        style="width: 30px;">
                    {{ __('Add New Episode') }}
                </h4>

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
                                    <span class="bs-stepper-label">{{ __('Episode Data') }}</span>
                                </button>
                            </div>

                            <div class="line"></div>

                            <div class="step" data-target="#date-time-part">
                                <button type="button" class="step-trigger" role="tab"
                                    aria-controls="date-time-part" id="date-time-part-trigger">
                                    <span class="bs-stepper-circle-matla">2</span>
                                    <span class="bs-stepper-label">{{ __('Date and Duration') }}</span>
                                </button>
                            </div>

                            <div class="line"></div>

                            <div class="step" data-target="#reminder-part">
                                <button type="button" class="step-trigger" role="tab" aria-controls="reminder-part"
                                    id="reminder-part-trigger">
                                    <span class="bs-stepper-circle-matla">3</span>
                                    <span class="bs-stepper-label">{{ __('Reminder') }}</span>
                                </button>
                            </div>

                        </div>
                        <!-- End Stepper Header -->

                        <form id="episode-form">
                            @csrf
                            <input type="hidden" name="episode_id" value="">
                                <div class="bs-stepper-content">
                                    <!-- Stepper Content -->
                                    <!-- Basic Information Part -->
                                    @include('workspace.program.details.episodesForm.data')
                                    <!-- Date and Duration Part -->
                                    @include('workspace.program.details.episodesForm.date-time')
                                    <!-- Reminder Part -->
                                    @include('workspace.program.details.episodesForm.reminder')

                                </div>
                        </form>

                        <div id="add-episode-loading" class="spinner-grow text-dark" role="status"
                            style="display: none;">
                            <span class="sr-only">Loading...</span>
                        </div>

                    </div>
                    <!-- End Stepper -->

                </div>
            </div>

        </div>
    </div>
</div>
