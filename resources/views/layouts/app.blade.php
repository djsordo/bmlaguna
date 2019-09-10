<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BMLaguna') }}</title>

    <link type="text/css" rel="stylesheet" href="/css/materialize.min.css"  media="screen,projection"/>
    <link href="/css/material-icons.css" rel="stylesheet">
    <link href="/css/select2-materialize.css" rel="stylesheet">
    
    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    <link href="/css/materialert.css" rel="stylesheet">

    
</head>
<body>
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/js/select2.min.js"></script>
    <script type="text/javascript" src="/js/select2-materialize.js"></script>
    <script type="text/javascript" src="/js/materialize.min.js"></script>

    @barraPrincipal
    @endbarraPrincipal

    <main class="container">
        @yield('content')
    </main>
  
</body>
</html>
