@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col s12 center">
            <h1>{{ $equipo->nombre }}</h1>
        </div>
        <div class="col s12 center">
            <h2 class="z-depth-1">{{$equipo->categoria->descripcion}} {{$equipo->genero->descripcion}} {{$equipo->temporada->descripcion}}</h2>
        </div>

        <div class="col s12">
            <a class="btn-floating waves-effect waves-light btn red lighten-1 modal-trigger right" href="#modal1"><i class="material-icons">add</i></a>
        </div>
    
        <div class="col s6">
            <ul class="collection with-header z-depth-1">
                <li class="collection-header"><span class="flow-text">Plantilla</span></li>
                @foreach($equipo->jugadores as $jugador)
                    <li class="collection-item avatar">
                        @if (is_null($jugador->rutaFoto()))
                            <img src="/images/sinfoto.jpg" alt="" class="circle">
                        @else
                            <img src="{{'/docs/'.$jugador->rutaFoto() }}" alt="" class="circle">
                        @endif
                        <div class="col s2">
                            <h5 class="red-text">{{$jugador->dorsal}}</h5>
                        </div>
                        
                        <div class="col s10">
                            <span class="title"> 
                                {{ $jugador->nombre . ' ' . $jugador->apellido1 . ' ' . $jugador->apellido2 }} 
                            </span>
                            <p >{{ date('d/m/Y', strtotime($jugador->f_nacimiento)) . ' (' . $jugador->edadReal($equipo->temporada->temporada) . ' años)'}} <br>
                                {{ $jugador->categoriaTemp($equipo->temporada->temporada) }}
                            </p>
                            <span  class="secondary-content">
                                <a href="/miembros/{{$jugador->id}}/edit" data-tooltip="Editar datos"><i class="material-icons black-text">edit</i></a>
                                <a href="/miembros/{{$jugador->id}}"><i class="material-icons black-text">assignment</i></a>
                                <a href="/equipos/{{$equipo->id}}/{{$jugador->id}}/{{ $jugador->jugadorEquipo->first()->descripcion }}/deasignar"><i class="material-icons teal-text">clear</i></a>
                            </span>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="col s6">
            <ul class="collection with-header z-depth-1">
                    <li class="collection-header"><span class="flow-text">Técnicos</span></li>
                    @foreach($equipo->oficiales as $oficial)
                    <li class="collection-item avatar">
                        @if (is_null($oficial->rutaFoto()))
                            <img src="/images/sinfoto.jpg" alt="" class="circle">
                        @else
                            <img src="{{'/docs/'.$oficial->rutaFoto() }}" alt="" class="circle">
                        @endif

                        <span class="title"> {{ $oficial->nombre . ' ' . $oficial->apellido1 . ' ' . $oficial->apellido2 }} </span>

                        @foreach ($oficial->funciones as $funcion)
                            @if (($funcion->pivot->equipo_id == $equipo->id) && ($funcion->descripcion != 'jugador'))
                                <p>{{ ucFirst($funcion->descripcion) }}</p>
                            @endif
                        @endforeach

                        <span class="secondary-content">
                            <a href="/miembros/{{$oficial->id}}/edit" data-tooltip="Editar datos"><i class="material-icons black-text">edit</i></a>
                            <a href="/miembros/{{$oficial->id}}"><i class="material-icons black-text">assignment</i></a>
                            <a href="/equipos/{{$equipo->id}}/{{$oficial->id}}/{{ $oficial->oficialEquipo($equipo->id)->first()->descripcion }}/deasignar"><i class="material-icons teal-text">clear</i></a>
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>

    </div>

            
    <div id="modal1" class="modal bottom-sheet">
        <div class="modal-content row">
            <div class="col s6">
                <ul class="collection with-header z-depth-1">
                    <li class="collection-header"><span class="flow-text">Jugadores Disponibles</span></li>
                    @foreach($equipo->jugadoresPosibles() as $jugadorPosible)
                        <li class="collection-item avatar">
                            @if (is_null($jugadorPosible->rutaFoto()))
                                <img src="/images/sinfoto.jpg" alt="" class="circle">
                            @else
                                <img src="{{'/docs/'.$jugadorPosible->rutaFoto() }}" alt="" class="circle">
                            @endif

                            <span class="title"> {{ $jugadorPosible->nombre . ' ' . $jugadorPosible->apellido1 . ' ' . $jugadorPosible->apellido2 }} </span>
                            <p>{{ date('d/m/Y', strtotime($jugadorPosible->f_nacimiento)) . ' (' . $jugadorPosible->edadTemp($equipo->temporada->temporada) . ' años)'}} <br>
                                {{ $jugadorPosible->categoriaTemp($equipo->temporada->temporada) }}
                            </p>
                            <a href="/equipos/{{$equipo->id}}/{{$jugadorPosible->id}}/jugador/asignar" class="secondary-content"><i class="material-icons">person_add</i></a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="col s6">
                <ul class="collection with-header z-depth-1">
                    <li class="collection-header"><span class="flow-text">Técnicos disponibles</span></li>
                    @foreach($equipo->oficialesPosibles() as $oficialPosible)
                        <li class="collection-item avatar">
                            @if (is_null($oficialPosible->rutaFoto()))
                                <img src="/images/sinfoto.jpg" alt="" class="circle">
                            @else
                                <img src="{{'/docs/'.$oficialPosible->rutaFoto() }}" alt="" class="circle">
                            @endif

                            <span class="title"> {{ $oficialPosible->nombre . ' ' . $oficialPosible->apellido1 . ' ' . $oficialPosible->apellido2 }} </span>
                            
                            <div class="secondary-content">
                                <a href="/equipos/{{$equipo->id}}/{{$oficialPosible->id}}/entrenador/asignar" class="teal-text text-lighten-1"><i class="material-icons">school</i></a><br>
                                <a href="/equipos/{{$equipo->id}}/{{$oficialPosible->id}}/delegado/asignar" class="teal-text text-lighten-1"><i class="material-icons">person_add</i></a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.modal');
            var instances = M.Modal.init(elems);
        });
    </script>
@endsection