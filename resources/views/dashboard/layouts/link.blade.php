 <link rel="icon" type="image/png"  href="{{ asset('public/img/matla_logo_in_client_side.png') }}" />
 <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
 <!-- Font Awesome Icons -->
 <link rel="stylesheet" href="{{ asset('public/dashboard/plugins/fontawesome-free/css/all.min.css') }}">
 <link rel="stylesheet" href="{{ asset('public/dashboard/dist/css/buttons.css') }}">
 <!-- Theme style -->
 @if (getCurrentLanguage() == 'ar')
     <link rel="stylesheet" href="{{ asset('public/dashboard/dist/css/admintle.rtl.min.css') }}">
     <link href="{{ asset('public/custom/css/font.css') }}" rel="stylesheet" />
 @else
     <link rel="stylesheet" href="{{ asset('public/dashboard/dist/css/adminlte.min.css') }}">
 @endif
 <link rel="stylesheet" href="{{ asset('public/css/toastr.min.css') }}">
 @include('custom_apps.pusher')
 @yield('style')
