@extends('membership.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row col-md-12">
                    <div class="col-md-12">
                        <div class="card card-matla card-outline">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('Ready to build your media workspace') }}</h3>
                            </div>
                            <div class="card-body p-0">
                                <form id="workspaceForm">
                                    @csrf
                                    <div class="bs-stepper workpace-create">
                                        <div class="bs-stepper-header" role="tablist">
                                            <div class="step" data-target="#basic-part">
                                                <button type="button" class="step-trigger" role="tab"
                                                    aria-controls="basic-part" id="basic-part-trigger">
                                                    <span class="bs-stepper-circle-matla">1</span>
                                                    <span class="bs-stepper-label">{{ __('Basic Information') }}</span>
                                                </button>
                                            </div>
                                            <div class="line"></div>
                                            <div class="step" data-target="#country-part">
                                                <button type="button" class="step-trigger" role="tab"
                                                    aria-controls="country-part" id="country-part-trigger">
                                                    <span class="bs-stepper-circle-matla">2</span>
                                                    <span class="bs-stepper-label">{{ __('Select Country') }}</span>
                                                </button>
                                            </div>
                                            <div class="line"></div>
                                            <div class="step" data-target="#media-part">
                                                <button type="button" class="step-trigger" role="tab"
                                                    aria-controls="media-part" id="media-part-trigger">
                                                    <span class="bs-stepper-circle-matla">3</span>
                                                    <span class="bs-stepper-label">{{ __('Select Media Activity') }}</span>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="bs-stepper-content">

                                            {{-- الخطوة 1 --}}
                                            <div id="basic-part" class="content" role="tabpanel"
                                                aria-labelledby="basic-part-trigger">
                                                <p>{{ __('Please Define Your Work Area') }}</p>

                                                <div class="form-group col-md-8">
                                                    <label for="name">{{ __('Workspace Name') }}
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" name="name" id="name" class="form-control"
                                                        placeholder="{{ __('Example : Media Workspace') }}">
                                                    <span class="text-danger" data-error="name"></span>
                                                </div>

                                                <div class="form-group col-md-8">
                                                    <label for="description">{{ __('Workspace Description') }}</label>
                                                    <textarea id="description" name="description" class="form-control" rows="4"
                                                        placeholder="{{ __('Write a short description for your team or job') }}"></textarea>
                                                    <span class="text-danger" data-error="description"></span>
                                                </div>

                                                <a class="btn btn-matla btn-next-step"
                                                    data-step="1">{{ __('Next') }}</a>
                                            </div>

                                            {{-- الخطوة 2 --}}
                                            <div id="country-part" class="content" role="tabpanel"
                                                aria-labelledby="country-part-trigger">
                                                <p>{{ __('Select Workspace Country') }}</p>

                                                <div class="form-group col-md-8">
                                                    <label>{{ __('Country') }} <span class="text-danger">*</span></label>
                                                    <select name="country_id" class="form-control country"
                                                        style="width: 100%;">
                                                        <option value="">{{ __('Select Country') }}</option>
                                                        @foreach ($countries as $country)
                                                            <option value="{{ $country->id }}">{{ $country->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger" data-error="country_id"></span>
                                                </div>

                                                <a class="btn btn-matla btn-next-step"
                                                    data-step="2">{{ __('Next') }}</a>
                                                <a class="btn btn-matla"
                                                    onclick="stepper.previous()">{{ __('Previous') }}</a>
                                            </div>

                                            {{-- الخطوة 3 --}}
                                            <div id="media-part" class="content" role="tabpanel"
                                                aria-labelledby="media-part-trigger">
                                                <h2>{{ __('What is the nature of your media activity?') }}</h2>
                                                <p>{{ __('Choose the activity most suitable for the workspace.') }}</p>

                                                <div class="row">
                                                    @foreach ($workspaceTypes as $workspaceType)
                                                        <div class="col-md-3 col-sm-6 col-12">
                                                            <div class="info-box workspace-type-card"
                                                                data-workspace-type="{{ $workspaceType->id }}">

                                                                <img src="{{ asset('public/img/' . $workspaceType->photo) }}"
                                                                    alt="{{ $workspaceType->name }}" width="30">

                                                                <div class="info-box-content">
                                                                    <span
                                                                        class="info-box-number">{{ $workspaceType->name }}</span>
                                                                    <p>{{ $workspaceType->description }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                    <input type="hidden" name="workspace_type_id" id="workspace_type_id">
                                                </div>

                                                <span class="text-danger d-block mb-2"
                                                    data-error="workspace_type_id"></span>

                                                <a class="btn btn-matla"
                                                    onclick="stepper.previous()">{{ __('Previous') }}</a>
                                                <button type="submit" class="btn btn-matla">{{ __('Confirm') }}</button>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
    <script>
        $('.country').select2();
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.stepper = new Stepper(document.querySelector('.workpace-create'));
        });
        $(document).on('click', '.workspace-type-card', function() {
            // إزالة التحديد من كل الكروت
            $('.workspace-type-card').removeClass('selected');
            // تحديد الكارت الذي ضغط عليه المستخدم
            $(this).addClass('selected');
            // الحصول على ID النوع المختار
            let workspaceTypeId = $(this).data('workspace-type');
            // تخزينه في الـ hidden input
            $('#workspace_type_id').val(workspaceTypeId);

        });
    </script>
    <script>
        $(function() {
            const $form = $('#workspaceForm');
            const panels = ['basic-part', 'country-part', 'media-part'];

            window.stepper = new Stepper(document.querySelector('.bs-stepper'), {
                linear: true
            });

            $('.workspace-type-card').on('click', function() {
                $('.workspace-type-card').removeClass('active');
                $(this).addClass('active');
                $('#workspace_type_id').val($(this).data('workspace-type'));
                $('[data-error="workspace_type_id"]').text('');
            });

            function clearErrors() {
                $('.alert-fallback').remove();
                $('[data-error]').text('');
            }

            // بتفهم شكل الـ trait بتاعك وشكل Laravel العادي
            function normalizeErrors(json) {
                const out = {};
                (function walk(node) {
                    if (Array.isArray(node)) {
                        node.forEach(walk);
                    } else if (node && typeof node === 'object') {
                        if ('field' in node && 'messages' in node) {
                            out[node.field] = [].concat(node.messages);
                        } else {
                            $.each(node, function(key, value) {
                                if (Array.isArray(value) && value.length && value.every(v =>
                                        typeof v === 'string')) {
                                    out[key] = value;
                                } else {
                                    walk(value);
                                }
                            });
                        }
                    }
                })(json);
                return out;
            }

            // بتعرض الأخطاء جوه الفورمة، وبترجّع رقم أول خطوة فيها غلط
            function showErrors(errors) {
                let firstStep = null;

                $.each(errors, function(field, msgs) {
                    const html = [].concat(msgs).join('<br>');
                    const $span = $(`[data-error="${field}"]`);

                    if ($span.length) {
                        $span.html(html);
                    } else {
                        $('.bs-stepper-content .content.active')
                            .prepend(`<div class="alert alert-danger alert-fallback">${html}</div>`);
                    }

                    const panelId = $(`[name="${field}"]`).closest('.content').attr('id');
                    const idx = panels.indexOf(panelId);
                    if (idx !== -1 && (firstStep === null || idx < firstStep)) firstStep = idx;
                });

                return firstStep;
            }

            // أي فشل من السيرفر يتعرض جوه الفورمة
            function handleFail(xhr) {
                const errors = normalizeErrors(xhr.responseJSON);

                if ($.isEmptyObject(errors)) {
                    const msg = (xhr.responseJSON && xhr.responseJSON.message) || 'حصل خطأ، حاول تاني';
                    $('.bs-stepper-content .content.active')
                        .prepend(`<div class="alert alert-danger alert-fallback">${msg}</div>`);
                    return null;
                }

                return showErrors(errors);
            }

            $('.btn-next-step').on('click', function() {
                const step = parseInt($(this).data('step'));
                const $panel = $(this).closest('.content');
                clearErrors();

                $.ajax({
                    url: `/member/create-workspace/validate/${step}`,
                    method: 'POST',
                    data: $panel.find(':input').serialize() +
                        '&_token=' + encodeURIComponent($form.find('input[name="_token"]').val()),
                    headers: {
                        'Accept': 'application/json'
                    },
                    success: () => stepper.next(),
                    error: (xhr) => handleFail(xhr)
                });
            });
        });
    </script>
@endsection
