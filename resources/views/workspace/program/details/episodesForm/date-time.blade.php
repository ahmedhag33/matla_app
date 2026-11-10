<div id="date-time-part" class="content" role="tabpanel" aria-labelledby="date-time-part-trigger">

    <div class="form-group mb-4">
        <label class="d-block">{{ __('Date and Duration') }}</label>
    </div>

    <div class="row">

        {{-- Episode Date --}}
        <div class="col-md-6 mb-3">
            <label for="episodeDateInput">
                {{ __('Episode Date') }}
                <span class="text-muted">
                    * {{ __('Available Days:') }} {{ $programDaysTostring ?? '' }}
                </span>
            </label>

            <div class="input-group date" id="air_date" data-target-input="nearest">
                <input type="text" id="episodeDateInput" name="air_date"
                    class="form-control datetimepicker-input" data-target="#air_date" />

                <div class="input-group-append" data-target="#air_date" data-toggle="datetimepicker">
                    <div class="input-group-text">
                        <i class="fa fa-calendar"></i>
                    </div>
                </div>
                <span class="text-danger" data-error="air_date"></span>
            </div>
        </div>

        {{-- Episode Time --}}
        <div class="col-md-6 mb-3">
            <label for="episodeTimeInput">
                {{ __('Episode Time') }}
                <span class="text-muted">*</span>
            </label>

            <div class="input-group date" id="air_time" data-target-input="nearest">
                <input type="text" id="episodeTimeInput" name="air_time"
                    class="form-control datetimepicker-input" data-target="#air_time" />

                <div class="input-group-append" data-target="#air_time" data-toggle="datetimepicker">
                    <div class="input-group-text">
                        <i class="far fa-clock"></i>
                    </div>
                </div>
                <span class="text-danger" data-error="air_time"></span>
            </div>
        </div>

        {{-- Duration Hours --}}
        <div class="col-md-6 mb-3">
            <label for="duration_hours">
                {{ __('Duration Hours') }}
                <span class="text-muted">*</span>
            </label>

            <select class="form-control" id="duration_hours" name="duration_hours">
                @foreach (defaultEpisodeDurationHours() as $hour)
                    <option value="{{ $hour }}">
                        {{ $hour }} {{ __('Hour') }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Duration Minutes --}}
        <div class="col-md-6 mb-3">
            <label for="duration_minutes">
                {{ __('Duration Minutes') }}
                <span class="text-muted">*</span>
            </label>

            <select class="form-control" id="duration_minutes" name="duration_minutes">
                @foreach (defaultEpisodeDurationMinutes() as $minute)
                    <option value="{{ $minute }}">
                        {{ $minute }} {{ __('Minute') }}
                    </option>
                @endforeach
            </select>
        </div>

    </div>
    <button type="button" class="btn btn-matla btn-previous-step" onclick="stepper.previous()">
        {{ __('Previous') }}
    </button>

    <button type="button" class="btn btn-matla btn-next-step" data-step="2">
        {{ __('Next') }}
    </button>

</div>
