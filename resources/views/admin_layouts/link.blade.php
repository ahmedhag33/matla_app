 <link rel="icon" type="image/png"  href="{{ asset('public/img/matla_logo_in_client_side.png') }}" />
 <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
 <!-- Font Awesome Icons -->
 <link rel="stylesheet" href="{{ asset('public/dashboard/plugins/fontawesome-free/css/all.min.css') }}">
 <!-- new -->
 <link rel="stylesheet" href="{{ asset('public/dashboard/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{ asset('public/dashboard/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="{{ asset('public/dashboard/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('public/dashboard/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('public/dashboard/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/dashboard/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="{{ asset('public/dashboard/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="{{ asset('public/dashboard/plugins/bs-stepper/css/bs-stepper.min.css') }}">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="{{ asset('public/dashboard/plugins/dropzone/min/dropzone.min.css') }}">
  <!-- Theme style -->
 <link rel="stylesheet" href="{{ asset('public/dashboard/dist/css/matla.css') }}">
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
