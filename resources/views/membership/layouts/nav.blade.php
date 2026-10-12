 <nav class="main-header navbar navbar-expand-md navbar-matla">
     <div class="container">
         <a href="" class="navbar-brand">
             <img src="{{ asset('public/img/matla_logo_in_workspace_side.png') }}" alt="Matla" height="50">
         </a>

         <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
             aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
             <span class="navbar-toggler-icon"></span>
         </button>

         <div class="collapse navbar-collapse order-3" id="navbarCollapse">
             <!-- Left navbar links -->
             <ul class="navbar-nav">
                 <li class="nav-item text-white">
                     <a href="#" class="nav-link">{{ __('Home') }}</a>
                 </li>
                 <li class="nav-item text-white">
                     <a href="#" class="nav-link">{{ __('Workpspaces') }}</a>
                 </li>
             </ul>
         </div>
     </div>
     <ul class="navbar-nav ml-auto">
         <li class="nav-item dropdown">
             <a class="nav-link" data-toggle="dropdown" href="#">
                 <img src="{{ asset('public/img/circle-user-regular-full.svg') }}" alt="Members" width="30"
                     class="rounded-circle">
             </a>
             <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                 <a href="#" class="dropdown-item">
                     {{ __('User Profile') }}
                 </a>
                 <div class="dropdown-divider"></div>
                 <a href="#" class="dropdown-item">
                     {{ __('Update Password') }}
                 </a>
                 <div class="dropdown-divider"></div>
                 <a href="#" class="dropdown-item">
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
                 <img src="{{ asset('public/img/bell-solid-full.svg') }}" alt="Members" width="30"
                     >
                 <span class="badge badge-matla navbar-badge-matla" style="display: none;">0</span>
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
