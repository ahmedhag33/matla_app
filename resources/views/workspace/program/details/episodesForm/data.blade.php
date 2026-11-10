<div id="basic-information-part" class="content" role="tabpanel" aria-labelledby="basic-information-part-trigger">

    <div class="form-group">
        <label>{{ __('Episode Data') }}</label>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="title">
                    {{ __('Episode Title') }}
                    <span class="text-muted">*</span>
                </label>

                <input type="text" placeholder="{{ __('Episode Title') }}" class="form-control" id="title"
                    name="title">
                <span class="text-danger" data-error="title"></span>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="description">
                    {{ __('Episode Description') }}
                </label>

                <textarea id="description" name="description" class="form-control" rows="4"
                    placeholder="{{ __('Episode Short Description') }}"></textarea>

                <span class="text-danger" data-error="description"></span>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-matla btn-next-step" onclick="stepper.next()">
        {{ __('Next') }}
    </button>

</div>
