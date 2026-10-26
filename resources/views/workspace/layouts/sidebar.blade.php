  <aside class="main-sidebar" style="background-color: #17233C !important;">
      <!-- Brand Logo -->
      <a href="{{ route('dashboard.index') }}" class="brand-link">
          <img src="{{ asset('public/img/matla_logo_in_workspace_side.png') }}" alt="Matla" height="100">
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  <img src="{{ asset('public/img/building-regular-full.svg') }}" class="img-circle elevation-2"
                      alt="User Image">
              </div>
              <div class="info text-white">
                  <b> {{ current_workspace()->name }}</b>
              </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">

                  <!-- Workspace Management -->
                  @if (auth()->guard('member')->user()->hasMainPermission('manage-workspace'))
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
                              @if (auth()->guard('member')->user()->hasPermission('edit-workspace'))
                                  <li class="nav-item">
                                      <a href="" class="nav-link text-white">
                                          <img src="{{ asset('public/img/gear-solid-full.svg') }}"
                                              alt="Workspace Settings" style="width: 30px;">
                                          <p>{{ __('Workspace Settings') }}</p>
                                      </a>
                                  </li>
                              @endif

                              @if (auth()->guard('member')->user()->hasPermission('invite-members'))
                                  <li class="nav-item">
                                      <a href="{{ route('workspace.invention.index',['slug' => request()->route('slug')]) }}" class="nav-link text-white">
                                          <img src="{{ asset('public/img/person-circle-plus-solid-full.svg') }}"
                                              alt="Invite Members" style="width: 30px;">
                                          <p>{{ __('Invite Members') }}</p>
                                      </a>
                                  </li>
                              @endif
                              @if (auth()->guard('member')->user()->hasPermission('view-members'))
                                  <li class="nav-item">
                                      <a href="" class="nav-link text-white">
                                          <img src="{{ asset('public/img/user-group-solid-full.svg') }}" alt="Members"
                                              style="width: 30px;">
                                          <p>{{ __('Members') }}</p>
                                      </a>
                                  </li>
                              @endif
                          </ul>
                      </li>
                  @endif
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
                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link text-white">
                          <img src="{{ asset('public/img/list-check-solid-full.svg') }}" alt="Program Management"
                              style="width: 30px;">
                          <p>
                              {{ __('Tasks Management') }}
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="" class="nav-link text-white">
                                  <img src="{{ asset('public/img/table-list-solid-full.svg') }}" alt="Programs"
                                      style="width: 30px;">
                                  <p>{{ __('Tasks') }}</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="" class="nav-link text-white">
                                  <img src="{{ asset('public/img/list-solid-full.svg') }}" alt="Programs"
                                      style="width: 30px;">
                                  <p>{{ __('My Tasks') }}</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link text-white">
                          <img src="{{ asset('public/img/newspaper-solid-full.svg') }}" alt="Program Management"
                              style="width: 30px;">
                          <p>
                              {{ __('News Management') }}
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="" class="nav-link text-white">
                                  <img src="{{ asset('public/img/newspaper-solid-full.svg') }}" alt="News"
                                      style="width: 30px;">
                                  <p>{{ __('News') }}</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="" class="nav-link text-white">
                                  <img src="{{ asset('public/img/cloud-arrow-up-solid-full.svg') }}"
                                      alt="Import News" style="width: 30px;">
                                  <p>{{ __('Import News') }}</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="" class="nav-link text-white">
                                  <img src="{{ asset('public/img/rss-solid-full.svg') }}" alt="News Service"
                                      style="width: 30px;">
                                  <p>{{ __('News Service') }}</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link text-white">
                          <img src="{{ asset('public/img/magnifying-glass-solid-full.svg') }}"
                              alt="Program Management" style="width: 30px;">
                          <p>
                              {{ __('Discovery Management') }}
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="" class="nav-link text-white">
                                  <img src="{{ asset('public/img/algolia-brands-solid-full.svg') }}"
                                      alt="Discovery Sources" style="width: 30px;">
                                  <p>{{ __('Discovery Sources') }}</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link text-white">
                          <img src="{{ asset('public/img/user-tie-solid-full.svg') }}" alt="Staff Management"
                              style="width: 30px;">
                          <p>
                              {{ __('Staff Management') }}
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="" class="nav-link text-white">
                                  <img src="{{ asset('public/img/person-circle-question-solid-full.svg') }}"
                                      alt="Guests" style="width: 30px;">
                                  <p>{{ __('Guests') }}</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="" class="nav-link text-white">
                                  <img src="{{ asset('public/img/user-gear-solid-full.svg') }}" alt="Guest Settings"
                                      style="width: 30px;">
                                  <p>{{ __('Guest Settings') }}</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link text-white">
                          <img src="{{ asset('public/img/code-compare-solid-full.svg') }}" alt="Review and Approval"
                              style="width: 30px;">
                          <p>
                              {{ __('Review and Approval') }}
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="" class="nav-link text-white">
                                  <img src="{{ asset('public/img/check-to-slot-solid-full.svg') }}"
                                      alt="Content Review" style="width: 30px;">
                                  <p>{{ __('Content Review') }}</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="" class="nav-link text-white">
                                  <img src="{{ asset('public/img/notes-medical-solid-full.svg') }}"
                                      alt="Review History" style="width: 30px;">
                                  <p>{{ __('Review History') }}</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link text-white">
                          <img src="{{ asset('public/img/border-all-solid-full.svg') }}" alt="Review and Approval"
                              style="width: 30px;">
                          <p>
                              {{ __('The Rundown') }}
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="" class="nav-link text-white">
                                  <img src="{{ asset('public/img/diagram-next-solid-full.svg') }}"
                                      alt="Rundown Settings" style="width: 30px;">
                                  <p>{{ __('Rundown Settings') }}</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="" class="nav-link text-white">
                                  <img src="{{ asset('public/img/pen-solid-full.svg') }}" alt="Script Espisodes"
                                      style="width: 30px;">
                                  <p>{{ __('Script Espisodes') }}</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link text-white">
                          <img src="{{ asset('public/img/users-between-lines-solid-full.svg') }}" alt="Collaboration"
                              style="width: 30px;">
                          <p>
                              {{ __('Collaboration') }}
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="" class="nav-link text-white">
                                  <img src="{{ asset('public/img/road-circle-check-solid-full.svg') }}"
                                      alt="Activities" style="width: 30px;">
                                  <p>{{ __('Activities') }}</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="" class="nav-link text-white">
                                  <img src="{{ asset('public/img/bell-solid-full.svg') }}" alt="Notifications"
                                      style="width: 30px;">
                                  <p>{{ __('Notifications') }}</p>
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
