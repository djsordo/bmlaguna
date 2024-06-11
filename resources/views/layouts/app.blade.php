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
    <link href="/css/custom.css" rel="stylesheet">
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
        <div class="col s12 offset-s1 red lighten-5">
            <main class="container">
                @yield('content')
            </main>
        </div>
    </div>
<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/7.17.2/firebase-app.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->

<script>
  // Your web app's Firebase configuration
  var firebaseConfig = {
    apiKey: "AIzaSyCZSTFr_13I99xxgEGRbx2qJ9NhI1Zbzwg",
    authDomain: "bmlaguna-86522.firebaseapp.com",
    databaseURL: "https://bmlaguna-86522.firebaseio.com",
    projectId: "bmlaguna-86522",
    storageBucket: "bmlaguna-86522.appspot.com",
    messagingSenderId: "507596368891",
    appId: "1:507596368891:web:c60ad3c9eaa341a683f95e"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
</script>
</body>

</html>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems, options);
  });
</script>
