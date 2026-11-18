<main class="matla-program-details">
    <section class="matla-program-overview">
        <div class="matla-program-main">
            <img src="{{ asset('public/img/program.png') }}" alt="{{ $program->name }}" class="matla-program-logo">
            <div class="matla-program-copy">
                <div class="matla-program-heading">
                    <h2>{{ $program->name }}</h2>
                    @if (isset($program->status_attribute))
                        <span class="matla-program-status">{!! $program->status_attribute !!}</span>
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
                        <span id="episode-count">0</span>
                    </div>
                    @if (auth()->guard('member')->user()->hasPermission('add-episodes'))
                        <button type="button" class="btn btn-matla matla-add-episode" data-toggle="modal"
                            data-target="#addEpisodeModal">
                            <i class="fas fa-plus"></i>{{ __('Add New Episode') }}
                        </button>
                    @endif
                </div>
                <div class="matla-table-container">
                    <div class="table-responsive">
                        <div id="episodesGrid">

                        </div>
                    </div>
                </div>
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
