  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="{{ route('dashboard.index') }}" class="brand-link">
          <span class="brand-text font-weight-light">{{ __('Trial Version') }}</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  <img src="{{ asset('public/img/da7ed7b0-5f66-4f97-a610-51100d3b9fd2.jpg') }}"
                      class="img-circle elevation-2" alt="User Image">
              </div>
              <div class="info">
                  <a href="#" class="d-block">{{ auth()->guard('admin')->user()->name }}</a>
              </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <img src="{{ asset('public/img/users-line-solid-full.svg') }}" alt="User Avatar"
                              alt="User Image" style="width: 30px;">
                          <p>
                              {{ __('Users Management') }}
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('dashboard.role.index') }}" class="nav-link">
                                  <img src="{{ asset('public/img/id-badge-solid-full.svg') }}" alt="User Avatar"
                                      alt="User Image" style="width: 30px;">
                                  <p>{{ __('The Role') }}</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('dashboard.user.index') }}" class="nav-link">
                                  <img src="{{ asset('public/img/users-solid-full.svg') }}" alt="User Avatar"
                                      alt="User Image" style="width: 30px;">
                                  <p>{{ __('Users') }}</p>
                              </a>
                          </li>
                      </ul>
                  </li>
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
