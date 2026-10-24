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
             <a class="nav-link" data-toggle="dropdown" href="#">
                 <i class="far fa-bell"></i>
                 <span class="badge badge-matla navbar-badge-matla" style="display: none;">3</span>
             </a>
             <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="display: none;">
                 <a href="#" class="dropdown-item">
                     <!-- Message Start -->
                     <div class="media">
                         <img src="{{ asset('public/img/user-solid-full.svg') }}" alt="User Avatar"
                             class="img-size-50 mr-3 img-circle">
                         <div class="media-body">
                             <h3 class="dropdown-item-title">
                                 رئيس التحرير
                             </h3>
                             <p class="text-sm">تم انشاء برنامج الكلاسيكو بواسطة رئيس التحرير</p>
                             <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 ساعات</p>
                         </div>
                     </div>
                     <!-- Message End -->
                 </a>
                 <div class="dropdown-divider"></div>
             </div>
         </li>
     </ul>
 </nav>
