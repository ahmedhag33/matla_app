<main class="matla-program-details">
    <section class="matla-program-overview">
        <div class="matla-program-main">
            <img src="{{ asset('public/img/photo-video-solid.svg') }}" alt="{{ $episode->title }}" width="118"
                height="118">
            <div class="matla-program-copy">
                <div class="matla-program-heading">
                    <h2>{{ $episode->title . ' - ' . $episode->program->name }}</h2>
                    @if (isset($episode->status_formatted))
                        <span class="matla-program-status">{!! $episode->status_formatted !!}</span>
                    @endif
                </div>
                @if ($episode->description)
                    <p class="matla-program-description">{{ $episode->description }}</p>
                @endif
            </div>
        </div>

        <div class="matla-program-stats">
            <div class="matla-stat-card">
                <i class="fas fa-layer-group"></i>
                <span>{{ __('Segments Count') }}</span><strong>{{ $episode->segment_count }}
                    {{ __('Segments') }}</strong>
            </div>
            <div class="matla-stat-card"><i class="far fa-clock"></i>
                <span>{{ __('Episode Duration') }}</span><strong>{{ $episode->duration_to_string }}</strong>
            </div>
            <div class="matla-stat-card"><i
                    class="far fa-calendar-alt"></i><span>{{ __('Date And Time Broadcast') }}</span><strong>{{ $episode->air_at_formatted }}</strong>
            </div>
            <div class="matla-stat-card">
                <i class="fas fa-bars"></i>
                <span>{{ __('Total Segments Duration') }}</span><strong>{{ '0' . ' ' . __('Minute') }}</strong>
            </div>
            <div class="matla-stat-card matla-stat-days">
                <i class="fas fa-circle-notch"></i>
                <span>{{ __('Remaining Duration') }}</span><strong>{{ '0' . ' ' . __('Minute') }}</strong>
            </div>
        </div>
    </section>

    <section class="matla-program-content">
        <div class="matla-tabs-header">
            <ul class="nav nav-pills matla-program-tabs" role="tablist">
                <li class="nav-item"><a class="nav-link active" href="#episodes" data-toggle="tab" role="tab"><i
                            class="fas fa-clapperboard"></i>{{ __('Episodes') }}</a></li>
            </ul>
        </div>

        <div class="tab-content matla-program-tab-content">
            <div class="tab-pane fade show active" id="episodes" role="tabpanel">
                <div class="matla-table-toolbar">
                    <div class="matla-table-heading">
                        <h3>{{ __('Episodes') }}</h3>
                        <span>{{ $episode->segments_count }} {{ __('Segments') }}</span>
                    </div>
                    @if (auth()->guard('member')->user()->hasPermission('add-segments'))
                        <button type="button" class="btn btn-matla matla-add-episode" data-toggle="modal"
                            data-target="#addSegmentModal">
                            <i class="fas fa-plus"></i>{{ __('Add New Segment') }}
                        </button>
                    @endif
                </div>

                @if ($episode->segments->isNotEmpty())
                    <div class="matla-table-container">
                        <div class="table-responsive">
                            <table class="table matla-episodes-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('Sort') }}</th>
                                        <th>{{ __('Title') }}</th>
                                        <th>{{ __('Duration') }}</th>
                                        <th>{{ __('Creator') }}</th>
                                        <th>{{ __('Segment Type') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($episode->segments as $segment)
                                        <tr data-id="{{ $segment->id }}">
                                            <td><span class="matla-episode-number">{{ $segment->segment_number }}</span>
                                            </td>
                                            <td class="matla-episode-title">{{ $segment->title }}</td>
                                            <td>{{ $segment->duration. ' ' . __('Minutes') ?? '-' }}</td>
                                            <td><span class="matla-creator"><i
                                                        class="fas fa-user"></i>{{ $segment->creator->name ?? '-' }}</span>
                                            </td>
                                            <td>{!! !empty($segment->type_to_string) ? $segment->type_to_string : '-' !!}</td>
                                            <td>{!! $segment->status_to_string !!}</td>
                                            <td>
                                                <div class="btn-group matla-actions">
                                                    <button type="button" class="btn matla-action-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        @if (auth()->guard('member')->user()->hasPermission('edit-episodes'))
                                                            <a class="dropdown-item edit-episode"
                                                                href="javascript:void(0)" edit_id="{{ $segment->id }}"
                                                                data-toggle="modal" data-target="#addEpisodeModal"><i
                                                                    class="fas fa-edit"></i>{{ __('Edit') }}</a>
                                                        @endif
                                                        @if (auth()->guard('member')->user()->hasPermission('delete-episodes'))
                                                            <a class="dropdown-item delete-episode"
                                                                href="javascript:void(0)"
                                                                delete_id="{{ $segment->id }}"><i
                                                                    class="fas fa-trash"></i>{{ __('Delete') }}</a>
                                                        @endif
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
                        <div class="matla-empty-icon"> <i class="fas fa-layer-group"></i>
                        </div>
                        <h3>{{ __('No Segments Found') }}</h3>
                        <p>{{ __('Start by adding the first segment to this episode.') }}</p>
                        @if (auth()->guard('member')->user()->hasPermission('add-segments'))
                            <button type="button" class="btn btn-matla" data-toggle="modal"
                                data-target="#addSegmentModal"><i
                                    class="fas fa-plus"></i>{{ __('Add New Segment') }}</button>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </section>
</main>
