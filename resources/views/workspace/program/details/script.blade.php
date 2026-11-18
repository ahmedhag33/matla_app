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
                        error: function(xhr) {
                            toastr.error(xhr.responseJSON.message ||
                                "{{ __('An unexpected error occurred.') }}");
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
<script>
    window.matlaEpisodes = {
        permissions: {
            edit: "{{ auth()->guard('member')->user()->hasPermission('edit-episodes') }}",

            delete: "{{ auth()->guard('member')->user()->hasPermission('delete-episodes') }}"
        },
        gridUrl: "{{ routeWorkspace('workspace.episode.all', ['programSlug' => $program->slug]) }}",
        detailsUrl: "{{ routeWorkspace('workspace.episode.details', ['episodeSlug' => '__SLUG__']) }}",
    };
</script>
<script>
    $(function() {

        $("#episodesGrid").jsGrid({
            height: "auto",
            width: "100%",
            autoload: true,
            filtering: true,
            sorting: true,
            paging: true,
            pageLoading: true,
            pageSize: 10,
            pageButtonCount: 5,
            tableClass: "table matla-episodes-table",
            controller: {
                loadData: function(filter) {
                    return $.ajax({
                        url: window.matlaEpisodes.gridUrl,
                        method: "GET",
                        data: filter,
                        dataType: "json"
                    }).then(function(response) {
                        // Update Episodes Count
                        $("#episode-count").text(
                            response.itemCount ?? response.itemsCount ?? 0
                        );
                        // Return data to jsGrid
                        return {
                            data: response.data ?? response.data ?? [],
                            itemsCount: response.itemCount ?? response.itemsCount ?? 0
                        };

                    });

                }
            },

            fields: [

                {
                    name: "episode_number",
                    title: "{{ __('Episode Number') }}",
                    type: "number",
                    width: 90,
                    align: "center"
                },

                {
                    name: "title",
                    title: "{{ __('Title') }}",
                    type: "text"
                },

                {
                    name: "air_at",
                    title: "{{ __('Air Date') }}",
                    type: "text",
                    sorting: false,
                    filtering: false
                },

                {
                    name: "reminder_duration",
                    title: "{{ __('Duration Between Air and Reminder') }}",
                    type: "text",
                    sorting: false,
                    filtering: false
                },

                {
                    name: "reminder_at",
                    title: "{{ __('Reminder Date') }}",
                    type: "text",
                    sorting: false,
                    filtering: false
                },

                {
                    name: "duration",
                    title: "{{ __('Duration and Broadcast') }}",
                    type: "text",
                    sorting: false,
                    filtering: false
                },

                {
                    name: "creator",
                    title: "{{ __('Creator') }}",
                    type: "text",
                    sorting: false
                },

                {
                    name: "status",
                    title: "{{ __('Status') }}",
                    type: "text",
                    sorting: false,
                    filtering: false
                },

                {
                    name: "id",
                    title: "{{ __('Actions') }}",
                    sorting: false,
                    filtering: false,
                    width: 100,
                    itemTemplate: function(value, item) {
                        let $container = $("<div>")
                            .addClass("btn-group matla-actions");
                        let $toggle = $("<button>", {
                            type: "button",
                            class: "btn matla-action-toggle",
                            "data-toggle": "dropdown",
                            "aria-haspopup": true,
                            "aria-expanded": false
                        }).append(
                            $("<i>").addClass("fas fa-ellipsis-h")
                        );
                        let $menu = $("<div>")
                            .addClass("dropdown-menu dropdown-menu-right");
                        // Edit Episode
                        if (window.matlaEpisodes.permissions.edit) {
                            let $edit = $("<a>", {
                                    href: "javascript:void(0)",
                                    class: "dropdown-item edit-episode",
                                    edit_id: item.id,
                                    "data-toggle": "modal",
                                    "data-target": "#addEpisodeModal"
                                })
                                .append(
                                    $("<i>").addClass("fas fa-edit")
                                )
                                .append(" {{ __('Edit') }}");

                            $menu.append($edit);

                        }
                        // Delete Episode
                        if (window.matlaEpisodes.permissions.delete) {
                            let $delete = $("<a>", {
                                    href: "javascript:void(0)",

                                    class: item.can_delete ?
                                        "dropdown-item delete-episode" :
                                        "dropdown-item disabled",

                                    delete_id: item.id
                                })
                                .append(
                                    $("<i>").addClass("fas fa-trash")
                                )
                                .append(
                                    item.can_delete ?
                                    " {{ __('Delete') }}" :
                                    " {{ __('Cannot delete episode with existing segments.') }}"
                                );

                            $menu.append($delete);

                        }
                        // Episode Details
                        let detailsUrl = window.matlaEpisodes.detailsUrl.replace(
                            "__SLUG__",
                            encodeURIComponent(item.slug)
                        );
                        let $details = $("<a>", {
                                href: detailsUrl,
                                class: "dropdown-item"
                            })
                            .append(
                                $("<i>").addClass("fas fa-eye")
                            )
                            .append(" {{ __('Episode Details') }}");
                        $menu.append($details);
                        $container.append($toggle, $menu);
                        return $container;
                    }

                }

            ],

        });
        $("#episodesGrid").jsGrid({
            noDataContent: $(
                '<div class="matla-empty-state"><div class="matla-empty-icon"><i class="fas fa-film"></i></div><h3>{{ __('No Episodes Found') }}</h3><p>{{ __('Start by adding the first episode to this program.') }}</p></div>'
            ),
        });

    });
</script>
