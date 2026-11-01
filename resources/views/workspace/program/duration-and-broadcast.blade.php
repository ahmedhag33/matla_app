  <div id="duration-and-broadcast-part" class="content" role="tabpanel"
      aria-labelledby="duration-and-broadcast-part-trigger">

      <div class="row">

          <div class="col-md-6">
              <div class="form-group">
                  <label>{{ __('Broadcast Schedule') }}</label>

                  <div class="form-check">
                      @foreach (broadcastSchedule() as $key => $item)
                          <div class="mb-2">
                              <input class="form-check-input" type="radio" name="broadcast_schedule"
                                  id="schedule-{{ $key }}" value="{{ $key }}">

                              <label class="form-check-label" for="schedule-{{ $key }}">
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
                          <select class="form-control" id="duration_hours" name="duration_hours">

                              @foreach (defaultEpisodeDurationHours() as $hour)
                                  <option value="{{ $hour }}">
                                      {{ $hour }} {{ __('Hour') }}
                                  </option>
                              @endforeach

                          </select>
                      </div>

                      <div class="col-md-6">
                          <select class="form-control" id="duration_minutes" name="duration_minutes">

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
                          <input class="form-check-input" type="radio" name="broadcast_mode"
                              id="mode-{{ $key }}" value="{{ $key }}">

                          <label class="form-check-label" for="mode-{{ $key }}">
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
                      data-placeholder="{{ __('Select Days Of The Week') }}" style="width: 100%;"
                      name="days_of_the_week[]">

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
