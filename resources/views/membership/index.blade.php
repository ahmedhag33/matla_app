@extends('membership.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('public/dashboard/dist/css/membership-home.css') }}">
@endsection

@section('content')
    <div class="content-wrapper matla-membership-home">

        {{-- Welcome hero --}}
        <section class="matla-home-hero">
            <div class="matla-home-hero-copy">
                <span class="matla-home-eyebrow">{{ __('Your media workspace') }}</span>
                <h1>{{ __('Welcome') . ' ' . auth()->guard('member')->user()->name }}</h1>
                <p>{{ __('My Workspace at the Media') }}</p>
            </div>

            <div class="matla-home-hero-art" aria-hidden="true">
                <div class="matla-hero-orbit matla-hero-orbit-one"></div>
                <div class="matla-hero-orbit matla-hero-orbit-two"></div>
                <div class="matla-hero-clapper">
                    <i class="fas fa-photo-video"></i>
                </div>
                <span class="matla-hero-spark matla-hero-spark-one"></span>
                <span class="matla-hero-spark matla-hero-spark-two"></span>
            </div>
        </section>

        {{-- Pending invitations --}}
        @if ($inventions->isNotEmpty())
            <section class="matla-invitations-section">
                <div class="matla-section-heading">
                    <div>
                        <span class="matla-section-kicker">{{ __('Workspace invitations') }}</span>
                        <h2>{{ __('Pending Invitations') }}</h2>
                    </div>
                    <span class="matla-count-badge">{{ $inventions->count() }}</span>
                </div>

                <div class="matla-invitations-grid">
                    @foreach ($inventions as $invention)
                        <article class="matla-invitation-card" id="accordion{{ $invention->id }}">
                            <div class="matla-invitation-symbol">
                                <i class="fas fa-envelope-open-text"></i>
                            </div>
                            <div class="matla-invitation-info">
                                <span>{{ __('You are invited to join') }}</span>
                                <h3>{{ $invention->workspace->name }}</h3>
                                <p>{{ __('Media Workspace') }}</p>
                            </div>
                            <button type="button"
                                    class="btn btn-matla btn-confirm"
                                    data-workspace-id="{{ $invention->workspace_id }}">
                                <i class="fas fa-check"></i>
                                {{ __('Accept Invitation') }}
                            </button>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- Workspaces --}}
        <section class="matla-workspaces-section">
            <div class="matla-section-heading">
                <div>
                    <span class="matla-section-kicker">{{ __('Your spaces') }}</span>
                    <h2>{{ __('Workspaces') }}</h2>
                </div>

                @if (auth()->guard('member')->user()->hasPermission('add-workspace'))
                    <a href="{{ route('workspace.create-workspace.index') }}" class="btn btn-matla matla-create-workspace">
                        <i class="fas fa-plus"></i>
                        {{ __('Add Workspace') }}
                    </a>
                @endif
            </div>

            @if (auth()->guard('member')->user()->workspaces()->exists())
                @php
                    $workspaces = auth()->guard('member')->user()->workspaces()->get();
                @endphp

                <div class="matla-workspaces-grid">
                    @foreach ($workspaces as $workspace)
                        <article class="matla-workspace-card">
                            <div class="matla-workspace-card-top">
                                <span class="matla-workspace-icon">
                                    <i class="fas fa-tv"></i>
                                </span>
                                <span class="matla-workspace-label">{{ __('Media Workspace') }}</span>
                            </div>

                            <div class="matla-workspace-card-content">
                                <h3>{{ $workspace->name }}</h3>
                                <p>{{ __('Manage your media work and content in one place.') }}</p>
                            </div>

                            <div class="matla-workspace-card-footer">
                                <a href="{{ route('workspace.dashboard.index', ['slug' => $workspace->slug]) }}"
                                   class="btn btn-matla matla-enter-workspace">
                                    {{ __('Access Workspace') }}
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                            </div>
                        </article>
                    @endforeach

                    @if (auth()->guard('member')->user()->hasPermission('add-workspace'))
                        <a href="{{ route('workspace.create-workspace.index') }}" class="matla-add-workspace-card">
                            <span class="matla-add-workspace-icon"><i class="fas fa-plus"></i></span>
                            <strong>{{ __('Create New Workspace') }}</strong>
                            <span>{{ __('Create a workspace for your media project.') }}</span>
                        </a>
                    @endif
                </div>
            @else
                <div class="matla-no-workspaces">
                    <div class="matla-no-workspaces-icon"><i class="fas fa-layer-group"></i></div>
                    <div class="matla-no-workspaces-copy">
                        <h3>{{ __('You have no workspace') }}</h3>
                        <p>{{ __('Do you want to create a new workspace?') }}</p>
                    </div>

                    @if (auth()->guard('member')->user()->hasPermission('add-workspace'))
                        <a href="{{ route('workspace.create-workspace.index') }}" class="btn btn-matla">
                            <i class="fas fa-plus"></i>
                            {{ __('Add Workspace') }}
                        </a>
                    @endif
                </div>
            @endif
        </section>

        {{-- Product capabilities --}}
        <section class="matla-home-features" aria-label="{{ __('Platform features') }}">
            <div class="matla-home-feature">
                <span class="matla-feature-icon"><i class="fas fa-play-circle"></i></span>
                <div>
                    <h3>{{ __('Program Management') }}</h3>
                    <p>{{ __('Organize programs and broadcast schedules.') }}</p>
                </div>
            </div>
            <div class="matla-home-feature">
                <span class="matla-feature-icon"><i class="fas fa-film"></i></span>
                <div>
                    <h3>{{ __('Episode Management') }}</h3>
                    <p>{{ __('Prepare episodes and manage their content.') }}</p>
                </div>
            </div>
            <div class="matla-home-feature">
                <span class="matla-feature-icon"><i class="fas fa-users"></i></span>
                <div>
                    <h3>{{ __('Team Management') }}</h3>
                    <p>{{ __('Manage roles and team permissions.') }}</p>
                </div>
            </div>
            <div class="matla-home-feature">
                <span class="matla-feature-icon"><i class="fas fa-sliders-h"></i></span>
                <div>
                    <h3>{{ __('Workspace Settings') }}</h3>
                    <p>{{ __('Customize your workspace settings.') }}</p>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.btn-confirm').on('click', function() {
                const workspaceId = $(this).data('workspace-id');

                Swal.fire({
                    title: "<b>{{ __('Do you want to accept the invitation?') }}</b>",
                    icon: "warning",
                    iconColor: "#17233C",
                    showCancelButton: true,
                    confirmButtonColor: "#17233C",
                    cancelButtonColor: "#F59E0B",
                    confirmButtonText: "{{ __('Accept') }}",
                    cancelButtonText: "{{ __('Cancel') }}"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('workspace.member.accept-invitation') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                workspace_id: workspaceId
                            },
                            success: function(data) {
                                window.location.href = data.url;
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
