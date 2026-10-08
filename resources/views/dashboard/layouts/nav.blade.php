 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
     <!-- Left navbar links -->
     <ul class="navbar-nav">
         <li class="nav-item">
             <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
         </li>
         @if (getCurrentLanguage() == 'ar')
             <li class="nav-item d-none d-sm-inline-block">
                 <a href="{{ getURLLocalization('en') }}" class="nav-link">English</a>
             </li>
         @else
             <li class="nav-item d-none d-sm-inline-block">
                 <a href="{{ getURLLocalization('ar') }}" class="nav-link">العربية</a>
             </li>
         @endif
         <li class="nav-item d-none d-sm-inline-block">
             <a onclick="logout();" class="nav-link">{{ __('Logout') }}</a>
         </li>
     </ul>

     <!-- Right navbar links -->
     <ul class="navbar-nav ml-auto">
         <!-- Navbar Search -->
         <!-- Messages Dropdown Menu -->
         <!-- Notifications Dropdown Menu -->
         <li class="nav-item dropdown">
             <a class="nav-link" data-toggle="dropdown" href="#">
                 <i class="far fa-bell"></i>
                 <span class="badge badge-warning navbar-badge" style="display: none;">0</span>
             </a>
         </li>
     </ul>
 </nav>
