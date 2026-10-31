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

                            <div class="bs-stepper-content">

                                <!-- Step 1: Basic Information -->
                                <div id="basic-information-part" class="content" role="tabpanel"
                                    aria-labelledby="basic-information-part-trigger">

                                    <div class="form-group">
                                        <label>{{ __('Basic Information') }}</label>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="program-name">
                                                    {{ __('Program Name') }}
                                                    <span class="text-muted">*</span>
                                                </label>

                                                <input type="text" placeholder="{{ __('Program Name') }}"
                                                    class="form-control" id="program-name" name="program_name">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="slug">
                                                    {{ __('Slug') }} (Slug)
                                                    <span class="text-muted">*</span>
                                                </label>

                                                <input type="text" placeholder="{{ __('Slug') }}"
                                                    class="form-control" id="slug" name="slug">

                                                <small class="form-text text-muted">
                                                    {{ __('Slug Description') }}
                                                </small>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description">
                                                    {{ __('Program Description') }}
                                                </label>

                                                <textarea id="description" name="description" class="form-control" rows="4"
                                                    placeholder="{{ __('Program Short Description') }}"></textarea>

                                                <span class="text-danger" data-error="description"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>
                                                    {{ __('Program Type') }}
                                                    <span class="text-muted">*</span>
                                                </label>

                                                <div class="row">

                                                    @foreach ($programsTypes as $programType)
                                                        <div class="col-md-3 col-sm-6 col-4">
                                                            <div class="info-box program-type-card"
                                                                data-program-type="{{ $programType->id }}">

                                                                <img src="{{ $programType->icon_at_full }}"
                                                                    alt="{{ $programType->name }}" width="30">

                                                                <div class="info-box-content">
                                                                    <span class="info-box-number">
                                                                        {{ $programType->name }}
                                                                    </span>

                                                                    <p>{{ $programType->description }}</p>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    @endforeach

                                                    <input type="hidden" name="program_type_id"
                                                        id="program_type_id">

                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <a class="btn btn-matla" onclick="stepper.next()">
                                        {{ __('Next') }}
                                    </a>

                                </div>
                                <!-- End Step 1 -->


                                <!-- Step 2: Program Providers -->
                                <div id="program-providers-part" class="content" role="tabpanel"
                                    aria-labelledby="program-providers-part-trigger">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ __('Select Presenters') }}</label>

                                                <select class="select-presenters" multiple="multiple"
                                                    data-placeholder="{{ __('Select Presenters') }}"
                                                    style="width: 100%;">

                                                    @foreach ($presenters as $presenter)
                                                        <option value="{{ $presenter->id }}">
                                                            {{ $presenter->name }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <a class="btn btn-matla" onclick="stepper.previous()">
                                        {{ __('Previous') }}
                                    </a>

                                    <a class="btn btn-matla" onclick="stepper.next()">
                                        {{ __('Next') }}
                                    </a>

                                </div>
                                <!-- End Step 2 -->


                                <!-- Step 3: Duration and Broadcast -->
                                <div id="duration-and-broadcast-part" class="content" role="tabpanel"
                                    aria-labelledby="duration-and-broadcast-part-trigger">

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ __('Broadcast Schedule') }}</label>

                                                <div class="form-check">
                                                    @foreach (broadcastSchedule() as $key => $item)
                                                        <div class="mb-2">
                                                            <input class="form-check-input" type="radio"
                                                                name="broadcast_schedule"
                                                                id="schedule-{{ $key }}"
                                                                value="{{ $key }}">

                                                            <label class="form-check-label"
                                                                for="schedule-{{ $key }}">
                                                                {{ $item }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    {{ __('Default Episode Duration') }}
                                                </label>

                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <select class="form-control" id="duration_hours"
                                                            name="duration_hours">

                                                            @foreach (defaultEpisodeDurationHours() as $hour)
                                                                <option value="{{ $hour }}">
                                                                    {{ $hour }} {{ __('Hour') }}
                                                                </option>
                                                            @endforeach

                                                        </select>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <select class="form-control" id="duration_minutes"
                                                            name="duration_minutes">

                                                            @foreach (defaultEpisodeDurationMinutes() as $minute)
                                                                <option value="{{ $minute }}">
                                                                    {{ $minute }} {{ __('Minute') }}
                                                                </option>
                                                            @endforeach

                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ __('Broadcast Type') }}</label>

                                                @foreach (broadcastMode() as $key => $item)
                                                    <div class="mb-2">
                                                        <input class="form-check-input" type="radio"
                                                            name="broadcast_mode" id="mode-{{ $key }}"
                                                            value="{{ $key }}">

                                                        <label class="form-check-label"
                                                            for="mode-{{ $key }}">
                                                            {{ $item }}
                                                        </label>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ __('Days Of The Week') }}</label>

                                                <select class="select-days-of-the-week" multiple="multiple"
                                                    data-placeholder="{{ __('Select Days Of The Week') }}"
                                                    style="width: 100%;">

                                                    @foreach (broadcastDays() as $key => $item)
                                                        <option value="{{ $key }}">
                                                            {{ $item }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <a class="btn btn-matla" onclick="stepper.previous()">
                                        {{ __('Previous') }}
                                    </a>

                                    <a class="btn btn-matla" onclick="stepper.next()">
                                        {{ __('Next') }}
                                    </a>

                                </div>
                                <!-- End Step 3 -->


                                <!-- Step 4: Additional Settings -->
                                <div id="additional-settings-part" class="content" role="tabpanel"
                                    aria-labelledby="additional-settings-part-trigger">


                                    <div class="form-group">
                                        <label>{{ __('Program Status') }}</label>
                                        @foreach (broadcastStatus() as $key => $item)
                                            <div class="mb-2">
                                                <input class="form-check-input" type="radio" name="program_status"
                                                    id="program-status-{{ $key }}"
                                                    value="{{ $key }}">

                                                <label class="form-check-label"
                                                    for="program-status-{{ $key }}">
                                                    {{ $item }}
                                                </label>
                                            </div>
                                        @endforeach
                                        <a class="btn btn-matla" onclick="stepper.previous()">
                                            {{ __('Previous') }}
                                        </a>

                                        <button type="submit" class="btn btn-matla btn-save">
                                            {{ __('Save') }}
                                        </button>

                                    </div>
                                    <!-- End Step 4 -->

                                </div>
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
