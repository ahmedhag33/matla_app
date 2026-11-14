<!DOCTYPE html>
@if (getCurrentLanguage() == 'ar')
    <html lang="ar" dir="rtl">
@else
    <html lang="en" dir="ltr">
@endif

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    {{-- Main CSS Files --}}
    @include('membership.layouts.link')

    {{-- Page Specific CSS --}}
    @yield('styles')
</head>

<body class="hold-transition layout-top-nav">

    <div class="wrapper">

        {{-- Main Navbar --}}
        @include('membership.layouts.nav')

        {{-- Page Content --}}
        @yield('content')

    </div>

    {{-- Main JavaScript Files --}}
    @include('membership.layouts.script')

    {{-- Page Specific JavaScript --}}
    @yield('script')

</body>

</html>
