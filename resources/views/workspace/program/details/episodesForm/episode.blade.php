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
                              <td><span class="matla-episode-number">{{ $episode->episode_number }}</span>
                              </td>
                              <td class="matla-episode-title">{{ $episode->title }}</td>
                              <td><i class="far fa-calendar"></i>
                                  {{ $episode->air_at_formatted }}</td>
                              <td>{{ $episode->duration_between_air_and_reminder ?? null ? $episode->duration_between_air_and_reminder . ' ' . __('Days') : '-' }}
                              </td>
                              <td>{!! '<i class="far fa-calendar"></i> ' . $episode->reminder_at_formatted ?? '-' !!}
                              </td>
                              <td><i class="far fa-clock"></i> {{ $episode->duration_to_string ?? '-' }}
                              </td>
                              <td><span class="matla-creator"><i
                                          class="fas fa-user"></i>{{ $episode->creator->name ?? '-' }}</span>
                              </td>
                              <td>{!! $episode->status_formatted !!}</td>
                              <td>
                                  <div class="btn-group matla-actions">
                                      <button type="button" class="btn matla-action-toggle" data-toggle="dropdown"
                                          aria-haspopup="true" aria-expanded="false"><i
                                              class="fas fa-ellipsis-h"></i></button>
                                      <div class="dropdown-menu dropdown-menu-right">
                                          @if (auth()->guard('member')->user()->hasPermission('edit-episodes'))
                                              <a class="dropdown-item edit-episode" href="javascript:void(0)"
                                                  edit_id="{{ $episode->id }}" data-toggle="modal"
                                                  data-target="#addEpisodeModal"><i
                                                      class="fas fa-edit"></i>{{ __('Edit') }}</a>
                                          @endif
                                          @if (auth()->guard('member')->user()->hasPermission('delete-episodes'))
                                              @if (WorkspaceView::check_segments_in_episode($episode->id))
                                                  <a class="dropdown-item disabled" href="javascript:void(0)"><i
                                                          class="fas fa-trash"></i>{{ __('Cannot delete episode with existing segments.') }}</a>
                                              @else
                                                  <a class="dropdown-item delete-episode" href="javascript:void(0)"
                                                      delete_id="{{ $episode->id }}"><i
                                                          class="fas fa-trash"></i>{{ __('Delete') }}</a>
                                              @endif
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
              <button type="button" class="btn btn-matla" data-toggle="modal" data-target="#addEpisodeModal"><i
                      class="fas fa-plus"></i>{{ __('Add Episode') }}</button>
          @endif
      </div>
  @endif
