<div id="content-type-part" class="content" role="tabpanel" aria-labelledby="content-type-part-trigger">

    <div class="form-group">
        <label>{{ __('Content Type') }}</label>
    </div>

    <div class="content-type-section" dir="rtl">

        <h4 class="content-type-title">{{ __('Select Content Type') }}</h4>

        <div class="content-type-options">

            <!-- خبر -->
            <label class="content-type-card active">

                <input type="radio" name="content_type" value="news" checked>

                <span class="content-type-radio"></span>

                <div class="content-type-icon news-icon">
                    <svg viewBox="0 0 48 48" fill="none">
                        <rect x="8" y="7" width="32" height="34" rx="3" stroke="currentColor"
                            stroke-width="3" />
                        <rect x="13" y="12" width="9" height="9" rx="1" fill="currentColor" />
                        <path d="M26 13H35M26 18H35M13 27H35M13 32H35M13 37H30" stroke="currentColor" stroke-width="2.5"
                            stroke-linecap="round" />
                    </svg>
                </div>

                <strong>{{ __('New') }}</strong>

                <small>{{ __('New Description') }}</small>
            </label>

            <!-- موضوع -->
            <label class="content-type-card">

                <input type="radio" name="content_type" value="topics">

                <span class="content-type-radio"></span>

                <div class="content-type-icon topic-icon">
                    <svg viewBox="0 0 48 48" fill="none">
                        <path d="M24 7L42 17L24 27L6 17L24 7Z" fill="currentColor" />
                        <path d="M8 24L24 33L40 24" stroke="currentColor" stroke-width="4" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M8 32L24 41L40 32" stroke="currentColor" stroke-width="4" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>

                <strong>{{ __('Topic') }}</strong>

                <small>{{ __('Topic Description') }}</small>
            </label>

            <!-- بحث -->
            <label class="content-type-card">

                <input type="radio" name="content_type" value="researchs">

                <span class="content-type-radio"></span>

                <div class="content-type-icon research-icon">
                    <svg viewBox="0 0 48 48" fill="none">
                        <circle cx="20" cy="20" r="12" stroke="currentColor" stroke-width="4" />
                        <path d="M29 29L40 40" stroke="currentColor" stroke-width="5" stroke-linecap="round" />
                        <path d="M15 20H25M20 15V25" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </div>

                <strong>{{ __('Research') }}</strong>

                <small>{{ __('Research Description') }}</small>

            </label>

        </div>

    </div>
    <div class="step-navigation">

        <a class="btn btn-matla btn-step-previous" href="javascript:void(0);" onclick="stepper.previous();">
            <span>{{ __('Previous') }}</span>
        </a>

        <a class="btn btn-matla btn-next-step" data-step="2">
            <span>{{ __('Next') }}</span>
        </a>

    </div>
</div>
