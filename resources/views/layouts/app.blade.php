<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Seo Stuff -->
    {!! seo() !!}

    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Scripts -->



</head>
<body>
<!-- Responsive navbar-->
<header class="p-3 bg-dark text-white">
    @include('partials.frontend.navbar')
</header>
<!-- Main Block -->
<main>
    @yield('content')
</main>
<!-- Footer -->
@include('partials.frontend.cta')
@include('partials.frontend.footer')
<!-- Scripts -->
@yield('scripts')

</body>
</html>
