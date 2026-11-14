<nav class="main-header navbar navbar-expand-md navbar-matla matla-membership-navbar">
    <div class="container matla-navbar-container">

        {{-- Brand: keep the existing logo and destination --}}
        <a href="{{ route('workspace.member.index') }}" class="navbar-brand matla-navbar-brand">
            <img src="{{ asset('public/img/matla_logo_in_workspace_side.png') }}" alt="Matla">
        </a>

        <button class="navbar-toggler order-1 matla-navbar-toggler" type="button" data-toggle="collapse"
            data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Main navigation --}}
        <div class="collapse navbar-collapse matla-navbar-links" id="navbarCollapse">
            <ul class="navbar-nav matla-main-nav">
                <li class="nav-item">
                    <a href="{{ route('workspace.member.index') }}" class="nav-link matla-nav-link matla-nav-home">
                        <i class="fas fa-home"></i>
                        {{ __('Home') }}
                    </a>
                </li>

                @if (auth()->guard('member')->user()->hasPermission('add-workspace'))
                    <li class="nav-item">
                        <a href="{{ route('workspace.create-workspace.index') }}"
                            class="nav-link matla-nav-link matla-nav-add">
                            <i class="fas fa-plus-circle"></i>
                            {{ __('Add Workspace') }}
                        </a>
                    </li>
                @endif
            </ul>
        </div>

        {{-- Account and notifications: same existing dropdowns/actions --}}
        <ul class="navbar-nav matla-navbar-tools">
            <li class="nav-item dropdown matla-navbar-tool-item">
                <a class="nav-link matla-navbar-tool-link" data-toggle="dropdown" href="#"
                    aria-label="{{ __('User account') }}">
                    <img src="{{ asset('public/img/circle-user-regular-full.svg') }}" alt="{{ __('Members') }}"
                        class="matla-navbar-user-icon">
                </a>

                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right matla-navbar-dropdown">
                    <a href="#" class="dropdown-item" style="display: none;">
                        {{ __('User Profile') }}
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item" style="display: none;">
                        {{ __('Update Password') }}
                    </a>
                    <div class="dropdown-divider"></div>
                    <a onclick="logout();" class="dropdown-item">
                        <i class="fas fa-sign-out-alt ml-2"></i>
                        {{ __('Logout') }}
                    </a>
                    <div class="dropdown-divider"></div>
                </div>
            </li>

            <li class="nav-item dropdown matla-navbar-tool-item">
                <a class="nav-link matla-navbar-tool-link" data-toggle="dropdown" href="#"
                    aria-label="{{ __('Notifications') }}">
                    <img src="{{ asset('public/img/bell-solid-full.svg') }}" alt="{{ __('Notifications') }}"
                        class="matla-navbar-bell-icon">
                    <span class="badge badge-matla navbar-badge-matla" style="display: none;">0</span>
                </a>

                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right matla-navbar-dropdown"
                    style="display: none;">
                    <a href="#" class="dropdown-item">
                        <div class="media">
                            <img src="{{ asset('public/img/user-solid-full.svg') }}" alt="User Avatar"
                                class="img-size-50 mr-3 img-circle">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">رئيس التحرير</h3>
                                <p class="text-sm">تم انشاء برنامج الكلاسيكو بواسطة رئيس التحرير</p>
                                <p class="text-sm text-muted">
                                    <i class="far fa-clock mr-1"></i> 4 ساعات
                                </p>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                </div>
            </li>
        </ul>
    </div>
</nav>
