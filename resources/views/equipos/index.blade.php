@extends('layouts.app')

@section('content')

@include('common.success')

<div class="col s12 m8">
    <div class="section">
        <div class="row">
            <div class="section valign-wrapper">
                <div class="col s7">
                    <span><h2>Lista de Equipos</h2></span>
                </div>
                <div class="col s2">
                    <a href="{{ route('equipos.create') }}" class="btn-floating red waves-effect"><i class="material-icons">add</i></a> 
                </div>
                <div class="col s3">
                    <form id="tempForm">
                        <div class="input-field col s10">
                            <select name="temporada_id" id="tempSelect">
                                @foreach ($temporadas as $temporada)
                                    <option value="{{ $temporada->id }}" {{ ($temporada->id == $tempActual_id) ? 'selected' : ''}}>{{ $temporada->descripcion}}</option>
                                @endforeach
                            </select>
                            <label for="tempselect">Temporada</label>
                        </div>  
                    </form>
                </div>
            </div>

            <div class="section">
                <ul class="collection z-depth-3">
                    @foreach($categorias as $categoria)
                        @if ($categoria->equipos->where('temporada_id', $tempActual_id)->count() != 0)
                            <li class="collection-header center"><h3>{{$categoria->descripcion}}</h3></li>
                            <li class="collection-item">
                                @foreach ($generos as $genero)
                                    @if ($categoria->equipos->where('genero_id', $genero->id)->where('temporada_id', $tempActual_id)->count() != 0)
                                        <ul class="collection z-depth-2">
                                            <li class="collection-header center"><div class="section"><h4>{{ucwords($genero->descripcion)}}</h4></div></li>

                                            @foreach ($genero->equipos as $equipo)
                                                @if (($equipo->categoria->id == $categoria->id) && ($equipo->temporada->id == $tempActual_id) ) 
                                                <div class="row valign-wrapper">
                                                <div class="col s10 offset-s1">
                                                    <li class="collection-item avatar z-depth-1 s10">
                                                    <a href="/equipos/{{$equipo->id}}"><i class="material-icons circle blue">group</i></a>
                                                    <h5>{{$equipo->nombre}}</h5>
                                                  
                                                        <div>{{ $equipo->jugadores->count()}} jugadores</div>
                                                        <div>{{ $equipo->oficiales->count()}} técnicos</div>
                                                        <a href="/equipos/{{$equipo->id}}/edit" class="secondary-content"><i class="material-icons green-text">edit</i></a>
                                                    </li>
                                                </div>
                                                <div class="col s1">
                                                    <form action="/equipos/{{$equipo->id}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-floating red"><i class="material-icons">delete</i></button>   
                                                    </form>
                                                </div>
                                                </div>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endif
                                @endforeach
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>




                {{-- <div class="section">
                    @foreach($equipos as $equipo)
                        <div class="card col s6">
                            <div class="card-content">
                                <span class="card-title center"><strong>{{$equipo->nombre}}</strong></span>
                                <h5 class="center">{{$equipo->categoria->descripcion}} {{$equipo->genero->descripcion}}</h5>
                                <div class="flow-text"> {{ $equipo->jugadores_count}} jugadores</div>
                                <div class="flow-text"> {{ $equipo->oficiales_count}} técnicos</div>
                            </div>
                            <div class="card-action">
                            <div class="row">
                                <div class="col s2">
                                    <a href="/equipos/{{$equipo->id}}" class="btn-floating blue"><i class="material-icons">group</i></a>
                                </div>
                                <div class="col s2 offset-s6">
                                    <a href="/equipos/{{$equipo->id}}/edit" class="btn-floating green"><i class="material-icons">edit</i></a>
                                </div>
                                <div class="col s2">
                                    <form action="/equipos/{{$equipo->id}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-floating black"><i class="material-icons">delete</i></button>   
                                    </form>
                                </div>
                            </div>
                            </div>
                        </div>
                    @endforeach
                </div> --}}
            </div>
        </div>
    </div>

    <script>

        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('select');
            var instances = M.FormSelect.init(elems);
        });

        $select = document.getElementById("tempSelect").onchange = function(){
            document.getElementById("tempForm").submit();
        };

    </script>
@endsection