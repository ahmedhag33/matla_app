<div id="task-context-part" class="content active" role="tabpanel" aria-labelledby="task-context-part-trigger">
    <div class="form-group">
        <label>{{ __('Task Context') }}</label>
    </div>

    <div class="task-context" dir="rtl">

        <div class="task-grid">

            <!-- البرنامج -->
            <div class="form-group">
                <label class="field-label">
                    {{ __('Program') }} <span class="required">*</span>
                </label>

                <div class="select-wrapper">
                    <select name="program_id" id="program_id" class="task-select" required>
                        <option value="">{{ __('Select Program') }}</option>
                        @foreach ($programs as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    <span class="field-icon"><i class="icon-arrow-down"></i></span>
                    <span class="text-danger" data-error="program_id"></span>
                </div>
            </div>

            <!-- الحلقة -->
            <div class="form-group">
                <label class="field-label">
                    {{ __('Episode') }} <span class="required">*</span>
                </label>

                <div class="select-wrapper">
                    <select name="episode_id" class="task-select" required disabled>
                        <option value="">{{ __('Select Program First') }}</option>
                    </select>
                    <span class="field-icon">▦</span>
                    <span class="text-danger" data-error="episode_id"></span>
                </div>
            </div>

        </div>

        <!-- نطاق المهمة -->
        <div class="form-group">

            <label class="field-label">
                {{ __('Task Scope') }} <span class="required">*</span>
            </label>

            <div class="scope-options">

                <!-- الحلقة بالكامل -->
                <label class="scope-card active">

                    <input type="radio" name="task_context" value="episode" checked>

                    <span class="radio-circle"></span>

                    <span class="scope-icon">▷</span>

                    <span class="scope-content">
                        <strong>{{ __('Entire Episode') }}</strong>
                        <small>{{ __('The task pertains to the entire episode content.') }}</small>
                    </span>

                </label>

                <!-- فقرة محددة -->
                <label class="scope-card">

                    <input type="radio" name="task_context" value="segment">

                    <span class="radio-circle"></span>

                    <span class="scope-icon">☷</span>

                    <span class="scope-content">
                        <strong>{{ __('Specific Segment') }}</strong>
                        <small>{{ __('Link the task to a specific segment of the episode.') }}</small>
                    </span>

                </label>
                <span class="text-danger" data-error="task_context"></span>
            </div>

        </div>

        <!-- اختيار الفقرة -->
        <div class="form-group segment-field" style="display: none;">

            <label class="field-label">
                {{ __('Segment') }} <span class="optional">({{ __('Optional') }})</span>
            </label>

            <div class="select-wrapper">
                <select name="segment_id" class="task-select" disabled>
                    <option value="">{{ __('Select Segment') }}</option>
                </select>
                <span class="field-icon">☷</span>
                <span class="text-danger" data-error="segment_id"></span>
            </div>
        </div>

    </div>

    <div class="step-navigation">
        <a class="btn btn-matla btn-next-step" data-step="1">
            <span>{{ __('Next') }}</span>
        </a>
    </div>
</div>
