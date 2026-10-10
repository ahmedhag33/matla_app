  <aside class="main-sidebar" style="background-color: #17233C !important;">
      <!-- Brand Logo -->
      <a href="{{ route('dashboard.index') }}" class="brand-link">
          <img src="{{ asset('public/img/matla_logo_in_workspace_side.png') }}" alt="Matla" height="100">
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="info text-white">
                  <b> {{ __('Workspace') }}</b>
              </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">

                  <!-- Workspace Management -->
                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link text-white">
                          <img src="{{ asset('public/img/code-merge-solid-full.svg') }}" alt="Workspace Management"
                              style="width: 30px;">
                          <p>
                              {{ __('Workspace Management') }}
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>

                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="" class="nav-link text-white">
                                  <img src="{{ asset('public/img/gear-solid-full.svg') }}" alt="Workspace Settings"
                                      style="width: 30px;">
                                  <p>{{ __('Workspace Settings') }}</p>
                              </a>
                          </li>

                          <li class="nav-item">
                              <a href="" class="nav-link text-white">
                                  <img src="{{ asset('public/img/person-circle-plus-solid-full.svg') }}"
                                      alt="Invite Members" style="width: 30px;">
                                  <p>{{ __('Invite Members') }}</p>
                              </a>
                          </li>

                          <li class="nav-item">
                              <a href="" class="nav-link text-white">
                                  <img src="{{ asset('public/img/user-group-solid-full.svg') }}" alt="Members"
                                      style="width: 30px;">
                                  <p>{{ __('Members') }}</p>
                              </a>
                          </li>
                      </ul>
                  </li>

                  <!-- Program Management -->
                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link text-white">
                          <img src="{{ asset('public/img/tv-solid-full.svg') }}" alt="Program Management"
                              style="width: 30px;">
                          <p>
                              {{ __('Program Management') }}
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="" class="nav-link text-white">
                                  <img src="{{ asset('public/img/chromecast-brands-solid-full.svg') }}" alt="Programs"
                                      style="width: 30px;">
                                  <p>{{ __('Programs') }}</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="" class="nav-link text-white">
                                  <img src="{{ asset('public/img/podcast-solid-full.svg') }}" alt="Program Episodes"
                                      style="width: 30px;">
                                  <p>{{ __('Program Episodes') }}</p>
                              </a>
                          </li>
                           <li class="nav-item">
                              <a href="" class="nav-link text-white">
                                  <img src="{{ asset('public/img/object-ungroup-regular-full.svg') }}" alt="Segments"
                                      style="width: 30px;">
                                  <p>{{ __('Segments') }}</p>
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
