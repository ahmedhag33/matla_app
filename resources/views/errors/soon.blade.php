<!DOCTYPE html>
<html lang="{{ GetCurrentLanguage() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <!-- SITE TITLE -->
    <title>Soon</title>
    @include('client.layouts.link')
    @include('client.layouts.custom-link')
    <style>
        .error-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .error_page {
            width: 100%;
        }
    </style>
</head>

<body data-spy="scroll" data-offset="80">

    <!-- START PRELOADER -->
    <div class="preloader">
        <div class="status">
            <div class="status-mes"></div>
        </div>
    </div>
    <!-- END PRELOADER -->

    <!-- START NAVBAR -->
    <div class="site-mobile-menu site-navbar-target">
        <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close mt-3">
                <span class="icon-close2 js-menu-toggle"></span>
            </div>
        </div>
        <div class="site-mobile-menu-body"></div>
    </div>
    <!-- END NAVBAR-->
    <!-- START 404 -->
    <section class="error-page section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-sm-12 col-xs-12 text-center">
                    <div class="error_page">
                        <h1>SOON</h1>
                        <h2>{{ __('Service Will Be Available Soon') }}</h2>
                        <a href="{{ route('index-page') }}" class="btn-contact-bg">{{ __('Back To Home') }}</a>
                    </div>
                </div><!--- END COL -->
            </div><!--- END ROW -->
        </div><!--- END CONTAINER -->
    </section>
    <!-- Latest jQuery -->
    @include('client.client-layout.script')
</body>

</html>
