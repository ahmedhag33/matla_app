 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
     <!-- Left navbar links -->
     <ul class="navbar-nav">
         <li class="nav-item">
             <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
         </li>
     </ul>
     <!-- Right navbar links -->
     <ul class="navbar-nav ml-auto">
         <li class="nav-item dropdown">
             <a class="nav-link" data-toggle="dropdown" href="#">
                 <img src="{{ asset('public/img/user-solid-full.svg') }}" alt="Members" width="20"
                     class="rounded-circle">
             </a>
             <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                 <a href="{{ route('workspace.member.index') }}" class="dropdown-item">
                     {{ __('User Profile') }}
                 </a>
                 <div class="dropdown-divider"></div>
                 <a href="#" class="dropdown-item" style="display: none;">
                     {{ __('Update Password') }}
                 </a>
                 <div class="dropdown-divider"></div>
                 <a href="#" class="dropdown-item" style="display: none;">
                     {{ __('Logout') }}
                 </a>
                 <div class="dropdown-divider"></div>
             </div>
         </li>
         <!-- Navbar Search -->
         <!-- Messages Dropdown Menu -->
         <!-- Notifications Dropdown Menu -->
         <li class="nav-item dropdown">
             <a class="nav-link dropdown-notifications-toggle" data-toggle="dropdown" href="javascript:void(0)">
                 <i class="far fa-bell"></i>
                 <span class="badge badge-matla navbar-badge-matla count-notifications" data-count="{{ auth()->guard('member')->user()->showNotifications(true)->count() }}"></span>
             </a>
             <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right dropdown-notifications">
                 @if (auth()->guard('member')->user()->showNotifications(true)->count() > 0)
                     @foreach (auth()->guard('member')->user()->showNotifications(true) as $notification)
                         <a href="{{ $notification->data['url'] }}" class="dropdown-item">
                             <!-- Message Start -->
                             <div class="media">
                                 <img src="{{ $notification->data['photo'] }}" alt="User Avatar"
                                     class="img-size-50 mr-3 img-circle">
                                 <div class="media-body">
                                     <h3 class="dropdown-item-title">
                                         {{ $notification->notifyBy->name }}
                                     </h3>
                                     <p class="text-sm">{{ $notification->message }}</p>
                                     <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>
                                         {{ $notification->created_at_formatted }}</p>
                                 </div>
                             </div>
                             <!-- Message End -->
                         </a>
                     @endforeach
                 @else
                     <a href="#" class="dropdown-item">
                         {{ __('No new notifications') }}
                     </a>
                 @endif
                 <div class="dropdown-divider"></div>
             </div>
         </li>
     </ul>
 </nav>
