    <div class="navbar-fixed">
            <nav class="red accent-4">
                <div class="nav-wrapper">
                    <a href="{{ url('/home') }}" class="brand-logo center">Balonmano Laguna</a>

                    @guest
                        <a href="" data-target="menu-responsive-guest" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                        <ul class="right hide-on-med-and-down">
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Registro</a></li>
                        </ul>
                    @else
                        <a href="" data-target="menu-responsive-user" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                        <ul class="left hide-on-med-and-down">
                            <li><a href="{{ route('miembros') }}">Miembros</a></li>
                            <li><a href="{{ route('equipos') }}">Equipos</a></li>
                            <li><a href="{{ route('categorias') }}">Categorías</a></li>
                            <li><a href="#" class="dropdown-trigger" data-target="dropMant">Mantenimientos<i class="material-icons right">arrow_drop_down</i></a></li>
                        </ul>
                        <ul class="right hide-on-med-and-down">
                            <li>
                                <a href="#" class="dropdown-trigger" data-target="dropUser">{{ Auth::user()->name }}
                                    <i class="material-icons right">arrow_drop_down</i>
                                </a>
                            </li>
                        </ul>
                    @endguest
                </div>
            </nav>
        </div>

        @guest
            <ul class="sidenav" id="menu-responsive-guest">
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}">Registro</a></li>
            </ul>
        @else
            <ul id="dropUser" class="dropdown-content">
                <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar Sesión</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>

            <ul id="dropUserResp" class="dropdown-content">
                <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar Sesión</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>

            <ul id="dropMant" class="dropdown-content">
                <li><a href="{{ route('equipaciones') }}">Equipaciones</a></li>
                <li><a href="{{ route('documentos') }}">Documentos</a></li>
            </ul>

            <ul class="sidenav" id="menu-responsive-user">
                <li><a href="{{ route('miembros') }}">Miembros</a></li>
                <li><a href="{{ route('equipos') }}">Equipos</a></li>
                <li><a href="{{ route('categorias') }}">Categorías</a></li>
                {{-- <li><a href="#" class="dropdown-trigger" data-target="dropMantResp">Mantenimientos<i class="material-icons right">arrow_drop_down</i></a></li> --}}
                <li>
                    <a href="#" class="dropdown-trigger" data-target="dropUserResp">{{ Auth::user()->name }}
                        <i class="material-icons right">arrow_drop_down</i>
                    </a>
                </li>
            </ul>
        @endguest    

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.dropdown-trigger');
        var instances = M.Dropdown.init(elems);
    });

</script>