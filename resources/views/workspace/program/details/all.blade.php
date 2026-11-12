 <main class="main">
     <div class="row">
         <section class="program-card-details">
             <img src="{{ asset('public/img/program.png') }}" alt="{{ $program->name }}" class="program-logo">
             <div class="program-description">
                 <h1>{{ $program->name }}</h1>

                 <img src="{{ $program->type->icon_at_full }}" alt="{{ $program->type->name }}" width="20">
                 {{ $program->type->name }}
                 <p>{{ $program->description }}</p>
             </div>
             <div class="stats">
                 <div class="stat">
                     <strong>{{ $program->team_members_count }} {{ __('members') }}</strong>
                     <span>{{ __('Program Team') }}</span>
                 </div>
                 <div class="stat">
                     <strong>{{ $program->episodes_count }}</strong>
                     <span>
                         {{ __('Number of Episodes') }}</span>
                 </div>
                 <div class="stat">
                     <strong>{{ $program->default_duration_minutes_to_string }} </strong>
                     <span>{{ __('Episode Duration') }}</span>
                 </div>
                 <div class="stat">
                     <strong>{{ $program->broadcast_schedule_attribute }}</strong>
                     <span>{{ __('Broadcast Schedule') }}</span>
                 </div>
                 <div class="stat">
                     <strong>{!! $program->broadcast_mode_attribute !!}</strong>
                     <span>{{ __('Broadcast Mode') }}</span>
                 </div>
                 <div class="stat">
                     <strong>{{ $program->created_at_formatted }}</strong>
                     <span>{{ __('Created At') }}</span>
                 </div>
                 <div class="stat">
                     <strong>
                         {{ $program->broadcastDays->pluck('day_at_from_enum')->join(' ') }}
                     </strong>
                     <span>{{ __('Day Schedule') }}</span>
                 </div>
             </div>
         </section>
     </div> <!-- End row -->
     <br>
     <div class="col-md-12">
         <div class="card">

             <div class="card-header p-2">
                 <ul class="nav nav-pills">

                     <li class="nav-item">
                         <a class="nav-link active" href="#episodes" data-toggle="tab">

                             {{ __('Episodes') }}

                         </a>
                     </li>

                     <li class="nav-item">
                         <a class="nav-link" href="#program-team" data-toggle="tab">

                             {{ __('Program Team') }}

                         </a>
                     </li>

                 </ul>
             </div>

             <div class="card-body tab-content">

                 {{-- Episodes --}}
                 <div class="tab-pane fade show active" id="episodes">

                     @if ($program->episodes->isNotEmpty())
                         <div class="card card-solid">
                             @if (auth()->guard('member')->user()->hasPermission('add-episodes'))
                                 <div class="card-header">
                                     <h3 class="card-title">
                                         <button type="button" class="btn btn-matla" data-toggle="modal"
                                             data-target="#addEpisodeModal">
                                             {{ __('Add New Episode') }}
                                         </button>
                                     </h3>
                                 </div>
                             @endif
                             <div class="card-body pb-0">
                                 <div class="row">
                                     <div class="card-body table-responsive p-0">
                                         <table class="table table-hover text-nowrap">
                                             <thead class="table-matla">
                                                 <tr>
                                                     <th>{{ __('Episode Number') }}</th>
                                                     <th>{{ __('Title') }}</th>
                                                     <th>{{ __('Air Date') }}</th>
                                                     <th>{{ __('Duration Between Air and Reminder') }}</th>
                                                     <th>{{ __('Reminder Date') }}</th>
                                                     <th>{{ __('Duration and Broadcast') }}</th>
                                                     <th>{{ __('Creator') }}</th>
                                                     <th>{{ __('Status') }}</th>
                                                     <th>{{ __('Actions') }}</th>
                                                 </tr>
                                             </thead>
                                             <tbody>
                                                 @foreach ($program->episodes as $episode)
                                                     <tr data-id="{{ $episode->id }}">
                                                         <td>{{ $episode->episode_number }}</td>
                                                         <td>{{ $episode->title }}</td>
                                                         <td>{{ $episode->air_at_formatted }}</td>
                                                         <td>{{ $episode->duration_between_air_and_reminder ?? null ? $episode->duration_between_air_and_reminder . ' ' . __('Days') : '-' }}
                                                         </td>
                                                         <td>{{ $episode->reminder_at_formatted ?? '-' }}</td>
                                                         <td>{{ $episode->duration_to_string ?? '-' }}</td>
                                                         <td>{{ $episode->creator->name ?? '-' }}</td>
                                                         <td>{!! $episode->status_formatted !!}</td>
                                                         <td>
                                                             <div class="btn-group">
                                                                 <button type="button"
                                                                     class="btn btn-default">....</button>
                                                                 <button type="button"
                                                                     class="btn btn-default dropdown-toggle dropdown-icon"
                                                                     data-toggle="dropdown">
                                                                     <span class="sr-only">Toggle Dropdown</span>
                                                                 </button>
                                                                 <div class="dropdown-menu" role="menu">
                                                                     <a class="dropdown-item edit-episode" href="javascript:void(0)"
                                                                         edit_id="{{ $episode->id }}"
                                                                         data-toggle="modal"
                                                                         data-target="#addEpisodeModal"><i
                                                                             class="fas fa-edit"></i>
                                                                         {{ __('Edit') }}</a>
                                                                     <a class="dropdown-item" href="javascript:void(0)"
                                                                         delete_id="{{ $episode->id }}"><i
                                                                             class="fas fa-trash"></i>
                                                                         {{ __('Delete') }}</a>
                                                                 </div>
                                                             </div>
                                                         </td>
                                                     </tr>
                                                 @endforeach
                                             </tbody>
                                         </table>
                                     </div>
                                 </div>
                             </div>
                         @else
                             <section class="content">
                                 <div class="error-page">

                                     <div class="error-content">

                                         <h1>
                                             <i class="fas fa-film text-warning-matla"></i>
                                             {{ __('No Episodes Found') }}
                                         </h1>

                                         @if (auth()->guard('member')->user()->hasPermission('add-episodes'))
                                             <button class="btn btn-matla" data-toggle="modal"
                                                 data-target="#addEpisodeModal">
                                                 {{ __('Add Episode') }}
                                             </button>
                                         @endif

                                     </div>

                                 </div>
                             </section>
                     @endif

                 </div>

                 {{-- Program Team --}}
                 <div class="tab-pane fade" id="program-team">

                     <div class="table-responsive p-0">

                         <table class="table table-hover text-nowrap">

                             <thead class="table-matla">
                                 <tr>
                                     <th>{{ __('Name') }}</th>
                                     <th>{{ __('The Role') }}</th>
                                 </tr>
                             </thead>

                             <tbody>
                                 @foreach ($program->teamMembers as $teamMember)
                                     <tr data-id="{{ $teamMember->id }}">
                                         <td>
                                             <img alt="Avatar" class="table-avatar-matla"
                                                 src="{{ asset('public/img/da7ed7b0-5f66-4f97-a610-51100d3b9fd2.jpg') }}">

                                             {{ $teamMember->name }}
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
     </div>
 </main>
