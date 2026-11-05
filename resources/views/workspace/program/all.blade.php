<section class="content">
    <div class="card-header">
        <h3 class="card-title">
            @if (auth()->guard('member')->user()->hasPermission('add-program'))
                <button type="button" class="btn btn-matla" data-toggle="modal" data-target="#add-program">
                    <span><i class="fas fa-plus"></i>
                        {{ __('Add Program') }}
                    </span>
                </button>
            @endif
        </h3>
    </div>
    <!-- Default box -->
    <div class="card card-solid">
        <div class="card-body pb-0">
            <div class="row">
                @forelse ($programs as $program)
                    <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch"
                        id="show-program-{{ $program->id }}">

                        <div class="card bg-primary d-flex flex-fill program-card">
                            <div class="card-header text-muted border-bottom-0">
                                <span class="badge bg-light">
                                    <img src="{{ $program->type->icon_at_full }}" alt="{{ $program->type->name }}"
                                        width="20">

                                    {{ $program->type->name }}
                                </span>
                            </div>

                            <div class="card-body pt-0">

                                <div class="row">

                                    <div class="col-7">

                                        <h2 class="lead program-title">
                                            <b>{{ $program->name }}</b>
                                        </h2>

                                        <p class="text-muted text-sm">
                                            <i class="far fa-calendar-alt"></i>

                                            @foreach ($program->broadcastDays as $day)
                                                <small>{{ $day->day_at_from_enum . ' ' }}</small>
                                            @endforeach
                                        </p>

                                        <p class="text-muted text-sm">
                                            <i class="fas fa-calendar-alt"></i>
                                            {{ $program->broadcast_schedule_attribute }}
                                        </p>

                                        <p class="text-muted text-sm">
                                            <i class="far fa-clock"></i>
                                            {{ $program->default_duration_minutes_to_string }}
                                        </p>

                                        <p class="text-muted text-sm">
                                            <i class="fas fa-podcast"></i>
                                            {!! $program->broadcast_mode_attribute !!}
                                        </p>

                                    </div>

                                    <div class="col-5 text-center">
                                        <img src="{{ asset('public/img/program.png') }}" alt="program"
                                            class="img-circle img-fluid program-image">
                                    </div>

                                </div>

                            </div>

                            <div class="card-footer mt-auto">
                                <div class="text-right">
                                    <button type="button" class="btn btn-sm bg-teal btn-matla" data-toggle="dropdown">
                                        <i class="fas fa-cog"></i>
                                    </button>
                                    <div class="dropdown-menu text-right" role="menu">
                                        @if (auth()->guard('member')->user()->hasPermission('edit-program'))
                                            <a class="dropdown-item edit-program"
                                                data-edit-program="{{ $program->id }}" href="javascript:void(0)">
                                                <i class="fas fa-edit"></i>
                                                {{ __('Edit') }}
                                            </a>
                                        @endif
                                        @if (auth()->guard('member')->user()->hasPermission('delete-program'))
                                            <a class="dropdown-item delete-program" delete_id="{{ $program->id }}"
                                                data-delete-program="{{ $program->id }}" href="javascript:void(0)">
                                                <i class="fas fa-recycle"></i>
                                                {{ __('Delete') }}
                                            </a>
                                        @endif
                                        @if (auth()->guard('member')->user()->hasPermission('edit-program'))
                                            <a class="dropdown-item" data-update-status="{{ $program->id }}"
                                                href="javascript:void(0)">
                                                <i class="fas fa-sync-alt"></i>
                                                {{ __('Update Status') }}
                                            </a>
                                        @endif
                                    </div>
                                    {{-- <a href="#" class="btn btn-sm bg-teal btn-matla">
                                                <i class="fas fa-cog"></i>
                                            </a> --}}
                                    <a href="{{ route('workspace.program.details', [
                                        'slug' => request()->route('slug'),
                                        'programSlug' => $program->slug,
                                    ]) }}"
                                        class="btn btn-sm btn-matla">
                                        <i class="fas fa-play"></i>
                                        {{ __('Manage Episodes') }}
                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>
                    @include('workspace.program.program-providers')
                @empty
                    <div class="error-page">
                        <h2 class="headline ">
                            <i class="fas fa-cloud"></i>
                        </h2>
                        <div class="error-content">
                            <h2>{{ __('No Data') }}</h2>
                            <p>
                                {{ __('There are no programs available at the moment.') }}
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
        <!-- /.card-body -->
        {{ $programs->links('workspace.pagination.custom') }}
        <!-- /.card-footer -->
    </div>
    <!-- /.card -->

</section>
