 <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
     <div class="container px-4">
         <a class="navbar-brand" href="#page-top">{{ __('Trial Version') }}</a>
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
             aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span
                 class="navbar-toggler-icon"></span></button>
         <div class="collapse navbar-collapse" id="navbarResponsive">
             <ul class="navbar-nav ms-auto">
                 <div style="display: none;">
                     @if (getCurrentLanguage() == 'ar')
                         <li class="nav-item"><a class="nav-link" href="{{ getURLLocalization('en') }}">English</a></li>
                     @else
                         <li class="nav-item"><a class="nav-link" href="{{ getURLLocalization('ar') }}">العربية</a></li>
                     @endif
                 </div>
                 <li class="nav-item"><a class="nav-link"
                         href="#">{{ __('Login as member at the workspace') }}</a></li>
                 <div style="display: none;">
                     @if (!auth()->check())
                         <li class="nav-item"><a class="nav-link" data-toggle="modal" data-target="#loginModal"
                                 href="javascript:void(0)">{{ __('Login') }}</a></li>
                     @else
                         <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                             <ul class="navbar-nav">
                                 <li class="nav-item dropdown">
                                     <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink"
                                         role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                         {{ __('My Account') }}
                                     </a>
                                     <ul class="dropdown-menu dropdown-menu-dark"
                                         aria-labelledby="navbarDarkDropdownMenuLink">
                                         <li><a class="dropdown-item"
                                                 href="{{ route('user.profile') }}">{{ __('User Profile') }}</a></li>
                                         <li><a class="dropdown-item" onclick="logout();">{{ __('Logout') }}</a></li>
                                     </ul>
                                 </li>
                             </ul>
                         </div>
                     @endif
                 </div>
             </ul>
         </div>
     </div>
 </nav>
