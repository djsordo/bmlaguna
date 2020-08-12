    
    <div class="navbar-fixed">
        <nav class="red accent-4">
            <div class="nav-wrapper">
                @auth
                    <a href="{{ url('/home') }}" class="brand-logo center">Balonmano Laguna</a>
                @endauth

                @guest
                    <a href="{{ url('/') }}" class="brand-logo center">Balonmano Laguna</a>

                    <a href="" data-target="menu-responsive-guest" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                    <ul class="right hide-on-med-and-down">
                        {{-- <li><a href="{{ route('login') }}">Login</a></li> --}}
                        {{-- <li><a href="{{ route('register') }}">Registro</a></li> --}}
                    </ul>
                    @else
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
                {{-- <li><a href="{{ route('login') }}">Login</a></li> --}}
                {{-- <li><a href="{{ route('register') }}">Registro</a></li> --}}
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
        @endguest    

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.dropdown-trigger');
        var instances = M.Dropdown.init(elems);
    });

</script>