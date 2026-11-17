<section class="content matla-programs-content">
    <div class="matla-programs-summary">
        <div class="matla-summary-card">
            <span class="matla-summary-icon"><i class="fas fa-layer-group"></i></span>
            <div><span>{{ __('Total Programs') }}</span><strong>{{ $programs->total() }}</strong></div>
        </div>
    </div>

    <div class="matla-programs-grid">
        @forelse ($programs as $program)
            @php
                $episodesCount = $program->episodes_count ?? $program->episodes()->count();
                $teamMembersCount = $program->team_members_count ?? $program->teamMembers()->count();
            @endphp

            <article class="matla-program-card" id="show-program-{{ $program->id }}"
                style="display: {{ auth()->guard('member')->user()->checkInProgramTeam($program->slug) ? 'flex' : 'none' }}">

                <div class="matla-program-card-top">
                    <span class="matla-program-type-badge">
                        @if ($program->type?->icon_at_full)
                            <img src="{{ $program->type->icon_at_full }}" alt="{{ $program->type->name }}"
                                width="18" height="18">
                        @endif
                        {{ $program->type->name }}
                    </span>

                    <div class="matla-program-card-menu dropdown">
                        <button type="button" class="matla-icon-button" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" aria-label="{{ __('Program options') }}">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right text-right">
                            @if (auth()->guard('member')->user()->hasPermission('edit-program'))
                                <a class="dropdown-item edit-program" data-edit-program="{{ $program->id }}"
                                    href="javascript:void(0)">
                                    <i class="fas fa-edit"></i> {{ __('Edit') }}
                                </a>
                            @endif
                            @if (auth()->guard('member')->user()->hasPermission('delete-program'))
                                @if (!WorkspaceView::check_episodes_in_program($program->id))
                                    <a class="dropdown-item delete-program" delete_id="{{ $program->id }}"
                                        data-delete-program="{{ $program->id }}" href="javascript:void(0)">
                                        <i class="fas fa-trash-alt"></i> {{ __('Delete') }}
                                    </a>
                                @else
                                    <a class="dropdown-item disabled" href="javascript:void(0)">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        {{ __('Cannot delete program with existing episodes.') }}
                                    </a>
                                @endif
                            @endif
                            @if (auth()->guard('member')->user()->hasPermission('edit-program'))
                                <a class="dropdown-item" data-update-status="{{ $program->id }}"
                                    href="javascript:void(0)">
                                    <i class="fas fa-sync-alt"></i> {{ __('Update Status') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="matla-program-card-main">
                    <div class="matla-program-card-copy">
                        <h2>{{ $program->name }}</h2>
                        @if ($program->description)
                            <p class="matla-program-description">{{ $program->description }}</p>
                        @endif
                    </div>
                    <img src="{{ asset('public/img/program.png') }}" alt="{{ $program->name }}"
                        class="matla-program-card-image">
                </div>

                <div class="matla-program-card-meta">
                    <div class="matla-program-meta-item">
                        <i class="far fa-calendar-alt"></i>
                        <span>
                            @forelse ($program->broadcastDays as $day)
                                {{ $day->day_at_from_enum }}@if (!$loop->last)
                                    ،
                                @endif
                            @empty
                                -
                            @endforelse
                        </span>
                        <small>{{ __('Broadcast Days') }}</small>
                    </div>
                    <div class="matla-program-meta-item">
                        <i class="far fa-clock"></i>
                        <span>{{ $program->default_duration_minutes_to_string }}</span>
                        <small>{{ __('Episode Duration') }}</small>
                    </div>
                    <div class="matla-program-meta-item">
                        <i
                            class="fas fa-film"></i><span>{{ $episodesCount }}</span><small>{{ __('Episodes') }}</small>
                    </div>
                    <div class="matla-program-meta-item">
                        <i
                            class="fas fa-users"></i><span>{{ $teamMembersCount }}</span><small>{{ __('Team Members') }}</small>
                    </div>
                </div>

                <div class="matla-program-card-footer">
                    <div class="matla-program-broadcast">
                        <i class="fas fa-broadcast-tower"></i>
                        {!! $program->broadcast_mode_attribute !!}
                        <span class="matla-broadcast-separator">·</span>
                        {{ $program->broadcast_schedule_attribute }}
                    </div>
                    <div class="matla-program-card-actions">
                        <a href="{{ route('workspace.program.details', ['slug' => request()->route('slug'), 'programSlug' => $program->slug]) }}"
                            class="btn matla-btn-outline">
                            <i class="fas fa-sliders-h"></i> {{ __('Program Details') }}
                        </a>
                        <a href="{{ route('workspace.program.details', ['slug' => request()->route('slug'), 'programSlug' => $program->slug]) }}"
                            class="btn btn-matla matla-manage-episodes">
                            {{ __('Manage Episodes') }} <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>
            </article>
        @empty
            <div class="matla-programs-empty">
                <div class="matla-empty-icon"><i class="fas fa-tv"></i></div>
                <h2>{{ __('No Data') }}</h2>
                <p>{{ __('There are no programs available at the moment.') }}</p>
                @if (auth()->guard('member')->user()->hasPermission('add-program'))
                    <button type="button" class="btn btn-matla" data-toggle="modal" data-target="#add-program">
                        <i class="fas fa-plus"></i> {{ __('Add Program') }}
                    </button>
                @endif
            </div>
        @endforelse
    </div>

    @if ($programs->hasPages())
        <div class="matla-programs-pagination">{{ $programs->links('workspace.pagination.custom') }}</div>
    @endif
</section>
