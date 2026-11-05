  <div id="program-providers-part" class="content" role="tabpanel" aria-labelledby="program-providers-part-trigger">

      <div class="form-group">
          <label>{{ __('Team') }}</label>
      </div>

      <div class="row">

          <div class="col-md-6">
              <div class="form-group">
                  <select id="team-members" name="team_members[]" class="form-control select2" multiple>
                      @foreach ($members as $member)
                          <option value="{{ $member->id }}"
                              data-image="{{ asset('public/img/da7ed7b0-5f66-4f97-a610-51100d3b9fd2.jpg') }}">
                              {{ $member->name }}
                          </option>
                      @endforeach
                  </select>
              </div>
          </div>

      </div>
      <a class="btn btn-matla" onclick="stepper.previous()">
          {{ __('Previous') }}
      </a>
      <a class="btn btn-matla btn-next-step" data-step="2">
          {{ __('Next') }}
      </a>

  </div>
