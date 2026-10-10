  <aside class="main-sidebar" style="background-color: #17233C !important;">
      <!-- Brand Logo -->
      <a href="{{ route('dashboard.index') }}" class="brand-link">
          <img src="{{ asset('public/img/matla_logo_in_workspace_side.png') }}" alt="Matla" height="80">
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="info text-white">
                  {{ __('Workspace') }}
              </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <li class="nav-item">
                      <a href="#" class="nav-link text-white">
                          <img src="{{ asset('public/img/users-line-solid-full.svg') }}" alt="User Avatar"
                              alt="User Image" style="width: 30px;">
                          <p>
                              {{ __('Users Management') }}
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="" class="nav-link text-white">
                                  <img src="{{ asset('public/img/id-badge-solid-full.svg') }}" alt="User Avatar"
                                      alt="User Image" style="width: 30px;">
                                  <p>{{ __('The Role') }}</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="" class="nav-link text-white">
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
