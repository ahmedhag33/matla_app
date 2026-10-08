<!DOCTYPE html>

@if (getCurrentLanguage() == 'ar')
    <html lang="ar" dir="rtl">
@else
    <html lang="en">
@endif

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>{{ __('Trial Version') }}</title>
    @include('client.layouts.link')
    @include('client.layouts.custom-link')
    @yield('style')
    <!-- Core theme CSS (includes Bootstrap)-->

</head>

<body id="page-top">
    <!-- Navigation-->
    @include('client.layouts.nav')
    <!-- Header-->
    @yield('content')
    <!-- Footer-->
    @include('client.layouts.footer')
    <!-- Bootstrap core JS-->
    @include('client.layouts.script')
    <!-- Core theme JS-->
    @include('client.layouts.custom-script')

    @yield('script')
</body>

</html>
