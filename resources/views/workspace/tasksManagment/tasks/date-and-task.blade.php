
<div id="date-and-task-part" class="content"
     role="tabpanel"
     aria-labelledby="date-and-task-part-trigger">

    <div class="task-assignment-wrapper" dir="rtl">

        <h5 class="assignment-title">
            {{ __('Task Assignment') }}
        </h5>

        <div class="assignment-row">

            <!-- Assigned To -->
            <div class="assignment-field">

                <label class="assignment-label">
                    {{ __('Assigned To') }}
                    <span class="required">*</span>
                </label>

                <select name="assigned_to" class="assignment-select">
                    <option value="">{{ __('Select User') }}</option>
                    <option value="1">محمد علي</option>
                </select>

            </div>

            <!-- Priority -->
            <div class="assignment-field">

                <label class="assignment-label">
                    {{ __('Priority') }}
                    <span class="required">*</span>
                </label>

                <div class="priority-options">

                    <label class="priority-option urgent">
                        <input type="radio" name="priority" value="urgent">
                        <span>{{ __('Urgent') }}</span>
                    </label>

                    <label class="priority-option high">
                        <input type="radio" name="priority" value="high" checked>
                        <span>{{ __('High') }}</span>
                    </label>

                    <label class="priority-option normal">
                        <input type="radio" name="priority" value="normal">
                        <span>{{ __('Normal') }}</span>
                    </label>

                </div>

            </div>

        </div>

        <!-- Date and Time: Original Code - Unchanged -->

        <div class="form-group">
            <label>{{ __('Date And Task') }}</label>
        </div>

        <div class="row">

            <div class="col-md-6 mb-3">
                <label for="episodeDateInput">
                    {{ __('Task Date') }}
                </label>

                <div class="input-group date" id="air_date" data-target-input="nearest">
                    <input type="text" id="episodeDateInput" name="air_date" class="form-control datetimepicker-input"
                        data-target="#air_date" />

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
                    {{ __('Task Time') }}
                    <span class="text-muted">*</span>
                </label>

                <div class="input-group date" id="air_time" data-target-input="nearest">
                    <input type="text" id="episodeTimeInput" name="air_time" class="form-control datetimepicker-input"
                        data-target="#air_time" />

                    <div class="input-group-append" data-target="#air_time" data-toggle="datetimepicker">
                        <div class="input-group-text">
                            <i class="far fa-clock"></i>
                        </div>
                    </div>
                    <span class="text-danger" data-error="air_time"></span>
                </div>
            </div>

        </div>

        <!-- Task Settings -->

        <div class="task-settings">

            <label class="task-setting-item">
                <span>{{ __('Requires Review Before Approval') }}</span>

                <input type="checkbox" name="requires_review" value="1">
                <span class="setting-switch"></span>
            </label>

            <label class="task-setting-item">
                <span>{{ __('Notify Assignee When Assigned') }}</span>

                <input type="checkbox" name="notify_assignee" value="1" checked>
                <span class="setting-switch"></span>
            </label>

        </div>

        <!-- Actions -->

        <div class="assignment-actions">

            <a class="btn btn-matla btn-assignment-previous"
               href="javascript:void(0);"
               onclick="stepper.previous();">
                {{ __('Previous') }}
            </a>

            <button type="submit" class="btn btn-matla btn-assignment-save">
                {{ __('Save') }}
            </button>

        </div>

    </div>

</div>
