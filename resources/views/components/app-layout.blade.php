<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!--begin::Head-->
<head>
    <title>{{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link rel="apple-touch-icon" sizes="57x57" href="/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/manifest.json">
    <meta name="msapplication-TileImage" content="/favicon/ms-icon-144x144.png">
    <!--begin::Plugins-->
    <link href="{{ asset_version('/plugins/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset_version('/plugins/fullcalendar/fullcalendar.bundle.js') }}"></script>
    <!--end::Plugins-->
    <!--begin::Global Stylesheets Bundle-->
    <link href="{{ asset_version('/css/fonts.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset_version('/css/plugins.bundle.css') }}'" rel="stylesheet" type="text/css">
    <link href="{{ asset_version('/css/style.bundle.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset_version('/css/custom.css') }}" rel="stylesheet" type="text/css">
    <!--end::Global Stylesheets Bundle-->

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src= 'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-PSHP743');</script>
    <!-- End Google Tag Manager -->
</head>
<!--end::Head-->

<!--begin::Body-->
<body id="kt_body" class="bg-body">



<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PSHP743" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<!--begin::Main-->
{{ $slot }}
<!--end::Main-->

<!--begin::Javascript-->
<script src="{{ asset_version('/js/plugins.bundle.js') }}"></script>
<script src="{{ asset_version('/js/scripts.bundle.js') }}"></script>
{{ $script ?? '' }}
<!--end::Javascript-->

<!--end::Body-->
</body>
</html>
