<main class="matla-program-details">
    <section class="matla-program-overview">
        <div class="matla-program-main">
            <img src="{{ asset('public/img/program.png') }}" alt="{{ $program->name }}" class="matla-program-logo">
            <div class="matla-program-copy">
                <div class="matla-program-heading">
                    <h2>{{ $program->name }}</h2>
                    @if (isset($program->status_formatted))
                        <span class="matla-program-status">{!! $program->status_formatted !!}</span>
                    @endif
                </div>
                <div class="matla-program-type">
                    @if ($program->type?->icon_at_full)
                        <img src="{{ $program->type->icon_at_full }}" alt="{{ $program->type->name }}" width="20"
                            height="20">
                    @endif
                    <span>{{ $program->type->name }}</span>
                </div>
                @if ($program->description)
                    <p class="matla-program-description">{{ $program->description }}</p>
                @endif
            </div>
        </div>

        <div class="matla-program-stats">
            <div class="matla-stat-card"><i
                    class="fas fa-users"></i><span>{{ __('Program Team') }}</span><strong>{{ $program->team_members_count }}
                    {{ __('members') }}</strong></div>
            <div class="matla-stat-card"><i
                    class="fas fa-clapperboard"></i><span>{{ __('Number of Episodes') }}</span><strong>{{ $program->episodes_count }}</strong>
            </div>
            <div class="matla-stat-card"><i
                    class="far fa-clock"></i><span>{{ __('Episode Duration') }}</span><strong>{{ $program->default_duration_minutes_to_string }}</strong>
            </div>
            <div class="matla-stat-card"><i
                    class="far fa-calendar-alt"></i><span>{{ __('Broadcast Schedule') }}</span><strong>{{ $program->broadcast_schedule_attribute }}</strong>
            </div>
            <div class="matla-stat-card"><i
                    class="fas fa-satellite-dish"></i><span>{{ __('Broadcast Mode') }}</span><strong>{!! $program->broadcast_mode_attribute !!}</strong>
            </div>
            <div class="matla-stat-card"><i
                    class="far fa-calendar-check"></i><span>{{ __('Created At') }}</span><strong>{{ $program->created_at_formatted }}</strong>
            </div>
            <div class="matla-stat-card matla-stat-days"><i
                    class="fas fa-calendar-week"></i><span>{{ __('Day Schedule') }}</span><strong>{{ $program->broadcastDays->pluck('day_at_from_enum')->join('، ') }}</strong>
            </div>
        </div>
    </section>

    <section class="matla-program-content">
        <div class="matla-tabs-header">
            <ul class="nav nav-pills matla-program-tabs" role="tablist">
                <li class="nav-item"><a class="nav-link active" href="#episodes" data-toggle="tab" role="tab"><i
                            class="fas fa-clapperboard"></i>{{ __('Episodes') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="#program-team" data-toggle="tab" role="tab"><i
                            class="fas fa-users"></i>{{ __('Program Team') }}</a></li>
            </ul>
        </div>

        <div class="tab-content matla-program-tab-content">
            <div class="tab-pane fade show active" id="episodes" role="tabpanel">
                <div class="matla-table-toolbar">
                    <div class="matla-table-heading">
                        <h3>{{ __('Episodes') }}</h3>
                        <span>{{ $program->episodes_count }} {{ __('Epsoides') }}</span>
                    </div>
                    @if (auth()->guard('member')->user()->hasPermission('add-episodes'))
                        <button type="button" class="btn btn-matla matla-add-episode" data-toggle="modal"
                            data-target="#addEpisodeModal">
                            <i class="fas fa-plus"></i>{{ __('Add New Episode') }}
                        </button>
                    @endif
                </div>

                @if ($program->episodes->isNotEmpty())
                    <div class="matla-table-container">
                        <div class="table-responsive">
                            <table class="table matla-episodes-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('Episode Number') }}</th>
                                        <th>{{ __('Title') }}</th>
                                        <th><i class="far fa-calendar"></i> {{ __('Air Date') }}</th>
                                        <th>{{ __('Duration Between Air and Reminder') }}</th>
                                        <th><i class="far fa-calendar"></i> {{ __('Reminder Date') }}</th>
                                        <th>
                                            <i class="fas fa-clock"></i>
                                            {{ __('Duration and Broadcast') }}
                                        </th>
                                        <th>{{ __('Creator') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($program->episodes as $episode)
                                        <tr data-id="{{ $episode->id }}">
                                            <td><span
                                                    class="matla-episode-number">{{ $episode->episode_number }}</span>
                                            </td>
                                            <td class="matla-episode-title">{{ $episode->title }}</td>
                                            <td><i class="far fa-calendar"></i>
                                                {{ $episode->air_at_formatted }}</td>
                                            <td>{{ $episode->duration_between_air_and_reminder ?? null ? $episode->duration_between_air_and_reminder . ' ' . __('Days') : '-' }}
                                            </td>
                                            <td>{!!  '<i class="far fa-calendar"></i> ' . $episode->reminder_at_formatted ?? '-' !!}
                                            </td>
                                            <td><i class="far fa-clock"></i> {{ $episode->duration_to_string ?? '-' }}
                                            </td>
                                            <td><span class="matla-creator"><i
                                                        class="fas fa-user"></i>{{ $episode->creator->name ?? '-' }}</span>
                                            </td>
                                            <td>{!! $episode->status_formatted !!}</td>
                                            <td>
                                                <div class="btn-group matla-actions">
                                                    <button type="button" class="btn matla-action-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        @if (auth()->guard('member')->user()->hasPermission('edit-episodes'))
                                                            <a class="dropdown-item edit-episode"
                                                                href="javascript:void(0)" edit_id="{{ $episode->id }}"
                                                                data-toggle="modal" data-target="#addEpisodeModal"><i
                                                                    class="fas fa-edit"></i>{{ __('Edit') }}</a>
                                                        @endif
                                                        @if (auth()->guard('member')->user()->hasPermission('delete-episodes'))
                                                            <a class="dropdown-item delete-episode"
                                                                href="javascript:void(0)"
                                                                delete_id="{{ $episode->id }}"><i
                                                                    class="fas fa-trash"></i>{{ __('Delete') }}</a>
                                                        @endif
                                                        <a class="dropdown-item"
                                                            href="{{ routeWorkspace('workspace.episode.details', ['episodeSlug' => $episode->slug]) }}"><i
                                                                class="fas fa-eye"></i>{{ __('Episode Details') }}</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="matla-empty-state">
                        <div class="matla-empty-icon"><i class="fas fa-film"></i></div>
                        <h3>{{ __('No Episodes Found') }}</h3>
                        <p>{{ __('Start by adding the first episode to this program.') }}</p>
                        @if (auth()->guard('member')->user()->hasPermission('add-episodes'))
                            <button type="button" class="btn btn-matla" data-toggle="modal"
                                data-target="#addEpisodeModal"><i
                                    class="fas fa-plus"></i>{{ __('Add Episode') }}</button>
                        @endif
                    </div>
                @endif
            </div>

            <div class="tab-pane fade" id="program-team" role="tabpanel">
                <div class="matla-table-toolbar">
                    <div class="matla-table-heading">
                        <h3>{{ __('Program Team') }}</h3><span>{{ $program->team_members_count }}
                            {{ __('members') }}</span>
                    </div>
                </div>
                <div class="matla-table-container">
                    <div class="table-responsive">
                        <table class="table matla-episodes-table matla-team-table">
                            <thead>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('The Role') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($program->teamMembers as $teamMember)
                                    <tr data-id="{{ $teamMember->id }}">
                                        <td><span class="matla-team-member"><img alt="Avatar"
                                                    class="table-avatar-matla"
                                                    src="{{ asset('public/img/da7ed7b0-5f66-4f97-a610-51100d3b9fd2.jpg') }}">{{ $teamMember->name }}</span>
                                        </td>
                                        <td>{{ $teamMember->role->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
