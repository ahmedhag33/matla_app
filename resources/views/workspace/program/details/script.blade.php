@if (session()->has('success-create-episode'))
    <script>
        toastr.success("{{ session('success-create-episode') }}");
    </script>
@endif
<script>
    $(document).ready(function() {
        const $form = $('#episode-form');
        const panels = ['basic-information-part', 'date-time-part', 'reminder-part'];
        moment.locale('{{ app()->getLocale() }}');
        const programDays = @json(array_keys($programDays));
        const date = moment().format('dddd، D MMMM YYYY');
        $('#air_date').datetimepicker({
            format: 'dddd، D MMMM YYYY',
            locale: '{{ app()->getLocale() }}',
            daysOfWeekDisabled: programDays,
            minDate: moment(),
        });
        $('#air_time').datetimepicker({
            format: 'h:mm A',
            locale: '{{ app()->getLocale() }}',
        });
        $('.reminder-checkbox').change(function() {
            if ($(this).is(':checked')) {
                $('#reminder-time-container').show();
            } else {
                $('#reminder-time-container').hide();
            }
        });

        function clearErrors() {
            $('.alert-fallback').remove();
            $('[data-error]').text('');
        }

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
            var slug = "{{ current_Workspace()->slug }}"
            const step = $(this).data('step');
            const $panel = $(this).closest('.content');
            clearErrors();

            $.ajax({
                url: `/${slug}/workspace/episodes/validate/${step}`,
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
        $(document).on('click', '.btn-save', function(e) {
            e.preventDefault();
            var formData = new FormData($($form)[0]);
            $.ajax({
                type: 'post',
                enctype: "multipart/form-data",
                url: "{{ routeWorkspace('workspace.episode.create') }}",
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $('#add-episode-loading').show();
                    $form.hide();
                },
                error: function(data) {
                    $('#add-episode-loading').hide();
                    $form.show();
                    if (data.status === 422) {
                        printError(data.responseJSON.message[0]);
                    } else {
                        toastr.error(
                            data.responseJSON.message ||
                            "{{ __('An error occurred') }}"
                        );
                    }
                },
                complete: function() {
                    $('#add-episode-loading').hide();
                    $form.show();
                },
                success: function(data) {
                    window.location.href = data.url;
                }
            });

            function printError(errors) {
                $.each(errors, function(index, value) {
                    $('.' + value.field + '_err').html(value.messages);
                });
            }
        });
        $(document).on('click', '.edit-episode', function() {
            var episodeId = $(this).attr('edit_id');
            var slug = "{{ current_Workspace()->slug }}";
            $.ajax({
                url: "{{ routeWorkspace('workspace.episode.get-by-id') }}",
                method: 'POST',
                data: {
                    episode_id: episodeId,
                    _token: "{{ csrf_token() }}"
                },
                headers: {
                    'Accept': 'application/json'
                },
                success: function(data) {
                    // Populate the form with the episode data
                    var episode = data.data;
                    $form.find('input[name="episode_id"]').val(episode.id);
                    $form.find('input[name="title"]').val(episode.title);
                    $form.find('textarea[name="description"]').val(episode.description);
                    $form.find('input[name="air_date"]').val(episode
                        .air_date_to_arabic_in_input);
                    $form.find('input[name="air_time"]').val(episode
                        .air_time_to_arabic_in_input);
                    $('#duration_hours option[value="' + episode.duration_hours + '"]')
                        .prop('selected', true);
                    $('#duration_minutes option[value="' + episode.duration_minutes + '"]')
                        .prop('selected', true);
                    if (episode.reminder_before_air) {
                        $('#reminder').prop('checked', true);
                        $('#reminder-time-container').show();
                        $('#reminder_time').val(episode.duration_between_air_and_reminder);
                    }
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON.message ||
                        "{{ __('An error occurred') }}");
                }
            });
        });
        $(document).on('click', '.delete-episode', function(e) {
            Swal.fire({
                title: "<b>{{ __('Do you Are Delete') }}</b>",
                icon: "warning",
                iconColor: "#17233C",
                showCancelButton: true,
                confirmButtonColor: "#17233C",
                cancelButtonColor: "#F59E0B",
                confirmButtonText: "{{ __('Delete') }}",
                cancelButtonText: "{{ __('Cancel') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    e.preventDefault();
                    var id = $(this).attr('delete_id');
                    $.ajax({
                        type: 'DELETE',
                        url: "{{ routeWorkspace('workspace.episode.delete') }}",
                        dataType: 'json',
                        data: {
                            _token: "{{ csrf_token() }}",
                            'episode_id': id,
                        },
                        success: function(data) {
                            $(`tr[data-id="${id}"]`).remove();
                            toastr.success(data.message);
                        }
                    });
                }
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'));
    });
</script>
