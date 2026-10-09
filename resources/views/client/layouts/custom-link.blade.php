 <link rel="icon" type="image/png"  href="{{ asset('public/img/matla_logo_in_client_side.png') }}" />
 @if (getCurrentLanguage() == 'ar')
     <link href="{{ asset('public/custom/css/style_ar.css') }}" rel="stylesheet" />
     <link href="{{ asset('public/custom/css/font.css') }}" rel="stylesheet" />
 @else
     <link href="{{ asset('public/custom/css/styles.css') }}" rel="stylesheet" />
 @endif
 <link href="{{ asset('public/client/css/login.css') }}" rel="stylesheet">
 <link rel="stylesheet" href="{{ asset('public/css/toastr.min.css') }}">
