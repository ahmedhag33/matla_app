  <div id="basic-information-part" class="content" role="tabpanel" aria-labelledby="basic-information-part-trigger">

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

                  <input type="text" placeholder="{{ __('Program Name') }}" class="form-control" id="program-name"
                      name="name">
                  <span class="text-danger" data-error="name"></span>
              </div>
          </div>

          <div class="col-md-6">
              <div class="form-group">
                  <label for="slug">
                      {{ __('Slug') }} (Slug)
                      <span class="text-muted">*</span>
                  </label>

                  <input type="text" placeholder="{{ __('Slug') }}" class="form-control" id="slug"
                      name="slug">
                  <span class="text-danger" data-error="slug"></span>

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
                              <div class="info-box program-type-card" data-program-type="{{ $programType->id }}">

                                  <img src="{{ $programType->icon_at_full }}" alt="{{ $programType->name }}"
                                      width="30">

                                  <div class="info-box-content">
                                      <span class="info-box-number">
                                          {{ $programType->name }}
                                      </span>

                                      <p>{{ $programType->description }}</p>
                                  </div>

                              </div>
                          </div>
                      @endforeach

                      <input type="hidden" name="program_type_id" id="program_type_id">
                      <span class="text-danger" data-error="program_type_id"></span>
                  </div>
              </div>
          </div>

      </div>

      <a class="btn btn-matla" onclick="stepper.next()">
          {{ __('Next') }}
      </a>

  </div>
