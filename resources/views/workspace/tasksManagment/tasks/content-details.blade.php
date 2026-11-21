<div id="content-details-part" class="content" role="tabpanel" aria-labelledby="content-details-part-trigger">

    <div class="content-details-wrapper">

        <!-- عنوان الخبر -->
        <div class="form-group">
            <label class="details-label">
                {{ __('Task Title') }} <span class="required">*</span>
            </label>

            <input type="text" name="title" class="details-input" placeholder="">
        </div>

        <!-- تفاصيل الخبر -->
        <div class="form-group">
            <label class="details-label">
                {{ __('Task Details') }} <span class="required">*</span>
            </label>

            <div class="description-editor">
                <textarea id="description" name="description"></textarea>
            </div>
        </div>

        <!-- المتطلبات والمصادر -->
        <div class="details-bottom">

            <!-- المتطلبات المطلوبة -->
            <div class="requirements-section">

                <label class="details-label">
                    {{ __('Required Requirements') }} <span class="required">*</span>
                </label>

                <div class="requirements-list">

                    <label class="requirement-item">
                        <input type="checkbox" name="requirements[]" value="ready_script">
                        <span>{{ __('Ready Script') }}</span>
                    </label>

                    <label class="requirement-item">
                        <input type="checkbox" name="requirements[]" value="documented_sources">
                        <span>{{ __('Documented Sources') }}</span>
                    </label>

                    <label class="requirement-item">
                        <input type="checkbox" name="requirements[]" value="supporting_images">
                        <span>{{ __('Supporting Images') }}</span>
                    </label>

                </div>

            </div>

            <!-- روابط ومصادر مرجعية -->
            <div class="reference-section">

                <label class="details-label">
                    {{ __('Reference Links or Sources') }}
                </label>

                <input type="url" name="reference_url" class="details-input reference-input" placeholder="">

            </div>

        </div>

        <!-- أزرار التنقل -->
        <div class="step-navigation">

            <a class="btn btn-matla btn-step-previous" href="javascript:void(0);" onclick="stepper.previous();">
                <span>{{ __('Previous') }}</span>
            </a>

            <a class="btn btn-matla btn-step-next" href="javascript:void(0);" onclick="stepper.next();">
                <span>{{ __('Next') }}</span>
            </a>

        </div>

    </div>

</div>
