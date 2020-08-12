    <ul class="sidenav sidenav-fixed red accent-4 section">
        <li>
            <div class="background center">
                <img src="/images/escudo.png">
            </div>
        </li>
        <li>
            <ul class="collapsible collapsible-accordion">
                <li>
                    <a class="collapsible-header white-text" style="font-size: 16px">Miembros<i class="material-icons right white-text">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                    <ul class="red accent-4">
                        <li><a class="white-text" style="font-size: 16px" href="{{ route('miembros') }}">Lista</a></li>
                        <li><a class="white-text" style="font-size: 16px" href="{{ route('miembros.create') }}">Nuevo Miembro</a></li>
                    </ul>
                    </div>
                </li>
            </ul>
        </li>

        <li>
            <ul class="collapsible collapsible-accordion">
                <li>
                    <a class="collapsible-header white-text" style="font-size: 16px">Equipos<i class="material-icons right white-text">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                    <ul class="red accent-4">
                        <li><a class="white-text" style="font-size: 16px" href="{{ route('equipos') }}">Lista</a></li>
                        <li><a class="white-text" style="font-size: 16px" href="{{ route('equipos.create') }}">Nuevo Equipo</a></li>
                    </ul>
                    </div>
                </li>
            </ul>
        </li>

        <li>
            <ul class="collapsible collapsible-accordion">
                <li>
                    <a class="collapsible-header white-text" style="font-size: 16px">Categorías<i class="material-icons right white-text">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                    <ul class="red accent-4">
                        <li><a class="white-text" style="font-size: 16px" href="{{ route('categorias') }}">Lista</a></li>
                        <li><a class="white-text" style="font-size: 16px" href="{{ route('categorias.create') }}">Nueva Categoría</a></li>
                    </ul>
                    </div>
                </li>
            </ul>
        </li>

        <li>
            <ul class="collapsible collapsible-accordion">
                <li>
                    <a class="collapsible-header white-text" style="font-size: 16px">Preinscripciones<i class="material-icons right white-text">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                    <ul class="red accent-4">
                        <li><a class="white-text" style="font-size: 16px" href="{{ route('preinscripciones') }}">Lista</a></li>
                        <li><a class="white-text" style="font-size: 16px" href="{{route ('preinscripciones.create')}}">Crear</a></li>
                    </ul>
                    </div>
                </li>
            </ul>
        </li>

        <li>
            <ul class="collapsible collapsible-accordion">
                <li>
                    <a class="collapsible-header white-text" style="font-size: 16px">Pagos<i class="material-icons right white-text">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                    <ul class="red accent-4">
                        <li><a class="white-text" style="font-size: 16px" href="{{ route('pagos') }}">Lista</a></li>
                    </ul>
                    </div>
                </li>
            </ul>
        </li>

        <li>
            <ul class="collapsible collapsible-accordion">
            <li>
                <a class="collapsible-header white-text" style="font-size: 16px" >Mantenimientos<i class="material-icons right white-text">arrow_drop_down</i></a>
                <div class="collapsible-body">
                <ul class="red accent-4">
                    <li><a class="white-text" style="font-size: 16px" href="{{ route('equipaciones') }}">Equipaciones</a></li>
                    <li><a class="white-text" style="font-size: 16px" href="{{ route('documentos') }}">Documentos</a></li>
                    <li><a class="white-text" style="font-size: 16px" href="{{ route('register') }}">Registro</a></li>
                </ul>
                </div>
            </li>
            </ul>
        </li>

    </ul>

<script>
    $(document).ready(function(){
        $('.collapsible').collapsible();
    });
</script>
