  <div id="additional-settings-part" class="content" role="tabpanel" aria-labelledby="additional-settings-part-trigger">


      <div class="form-group">
          <label>{{ __('Program Status') }}</label>
          @foreach (broadcastStatus() as $key => $item)
              <div class="mb-2">
                  <input class="form-check-input" type="radio" name="program_status"
                      id="program-status-{{ $key }}" value="{{ $key }}">

                  <label class="form-check-label" for="program-status-{{ $key }}">
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
