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
                    <select name="program_id" class="task-select" required>
                        <option value="">{{ __('Select Program') }}</option>
                        @foreach ($programs as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    <span class="field-icon"><i class="icon-arrow-down"></i></span>
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
                </div>
            </div>

        </div>

        <!-- نطاق المهمة -->
        <div class="form-group">

            <label class="field-label">
                نطاق المهمة <span class="required">*</span>
            </label>

            <div class="scope-options">

                <!-- الحلقة بالكامل -->
                <label class="scope-card active">

                    <input type="radio" name="task_scope" value="episode" checked>

                    <span class="radio-circle"></span>

                    <span class="scope-icon">▷</span>

                    <span class="scope-content">
                        <strong>{{ __('Entire Episode') }}</strong>
                        <small>{{ __('The task pertains to the entire episode content.') }}</small>
                    </span>

                </label>

                <!-- فقرة محددة -->
                <label class="scope-card">

                    <input type="radio" name="task_scope" value="segment">

                    <span class="radio-circle"></span>

                    <span class="scope-icon">☷</span>

                    <span class="scope-content">
                        <strong>{{ __('Specific Segment') }}</strong>
                        <small>{{ __('Link the task to a specific segment of the episode.') }}</small>
                    </span>

                </label>

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
            </div>

        </div>

    </div>

    <a class="btn btn-matla btn-next-step" href="javascript:void(0);" onclick="stepper.next();">
        {{ __('Next') }}
    </a>
</div>
