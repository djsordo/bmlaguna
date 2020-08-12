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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
   
    <link href="/css/materialert.css" rel="stylesheet">

    
</head>

<body class=" red lighten-5">
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/js/select2.min.js"></script>
    <script type="text/javascript" src="/js/select2-materialize.js"></script>
    <script type="text/javascript" src="/js/materialize.min.js"></script>

    @empty ($quitaBarra)
        @barraPrincipal
        @endbarraPrincipal
    @endempty

    @auth
        @menuLateral
        @endmenuLateral
    @endauth

    <div class="row">
        <div class="col s10 offset-s2 red lighten-5">
            <main class="container">
                @yield('content')
            </main>
        </div>
    </div>
  
</body>

</html>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems, options);
  });
</script>
