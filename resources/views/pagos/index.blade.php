@extends('layouts.app')

@section('content')
@include('common.errors')

<div class="section">
    <div class="card-panel col s12 center">
        <h4>Listado de Pagos</h4>
    </div>

    <div class="row">
        <div class="col s12">
            <form id="tempForm">
                <div class="card col s12" style="height:200px">
                    <div class="card-content">
                        <span class="card-title">Criterios de búsqueda</span>
                        <div class="input-field col s2">
                            <select name="temporada_id" id="tempSelect">
                                @foreach ($temporadas as $temporada)
                                    <option value="{{ $temporada->id }}" {{ ($temporada->id == $tempActual_id) ? 'selected' : ''}}>{{ $temporada->descripcion}}</option>
                                @endforeach
                            </select>
                            <label for="tempSelect">Temporada</label>
                        </div>

                        <div class="input-field col s7">
                            <select name="equipo_id" id="equipoSelect">
                                <option value="">Todos los miembros, tengan equipo o no</option>
                                <option value="0" {{ ($equipoActual_id == '0') ? 'selected' : ''}}>Miembros sin equipo</option>

                                @foreach ($equipos as $equipo)
                                    <option value="{{ $equipo->id }}" {{ ($equipo->id == $equipoActual_id) ? 'selected' : ''}}>{{ $equipo->categoria->descripcion.'-'.$equipo->genero->descripcion.'-'.$equipo->nombre}}</option>
                                @endforeach
                            </select>
                            <label for="equipoSelect">Equipo</label>
                        </div>

                        <div class="col s3">
                            <div class="input-field">
                                <i class="material-icons prefix">search</i>
                                <input type="text" id="nombre" name="nombre" {{-- class="autocomplete" --}} autocomplete="off" value="{{$textoBusqueda}}">
                                <label for="nombre">Nombre</label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card-panel col s12">
        <span class="col s12 flow-text">{{$nombreEquipo}}</span>
        <div class="col s4">
            @if (!is_null($nJugadores))
                <label for="nJugadores">Número de jugadores en el equipo:</label><br>
                <span id="nJugadores" class="black-text">{{ $nJugadores }}</span>
            @else
                <label for="nJugadores">Número de jugadores:</label><br>
                <span id="nJugadores" class="black-text">{{ $pagos->total() }}</span>
            @endif
        </div>
        <div class="col s4">
            <label for="totalPagos">Total pagado:</label><br>
            <span id="totalPagos" class="black-text">{{ $totalPagos }}</span>
        </div>
        <div class="col s4">
            @if (!is_null($totalAPagar))
                <label for="totalAPagar">Total a pagar:</label><br>
                <span id="totalAPagar" class="black-text">{{ $totalAPagar }}</span>
            @endif
        </div>
    </div>

    <div class="col s12">
        <ul class="collapsible popout">
            <li>
                <div class="collapsible-header">
                    <span class="col s8"><b>Nombre</b></span>
                    <span class="col s2 right-align"><b>Pagado</b></span>
                    <span class="col s2 right-align"><b>A Pagar</b></span>
                </div>
            </li>
            @foreach ($pagos as $pago)
                <li>
                    <div class="collapsible-header">
                        <span class="col s8">{{$pago->miembro->nombre. ' ' . $pago->miembro->apellido1 . ' ' . $pago->miembro->apellido2}}</span>
                        <span class="col s2 right-align">{{$pago->sumPagado()}}</span>
                        <span class="col s2 right-align">{{$pago->miembro->aPagar($tempElegida)}}</span>
                    </div>
                    <div class="collapsible-body row">
                        <div class="col s12">
                            <div class="col s2"><label>Fecha de Pago</label></div>
                            <div class="col s2"><label>Fecha de Vencimiento</label></div>
                            <div class="col s2"><label>Tipo de Pago</label></div>
                            <div class="col s2"><label>Estado</label></div>
                            <div class="col s4 right-align"><label>Importe</label></div>
                        </div>

                        <div class="col s12 card">
                        @foreach ($pago->miembro->listaPagos($tempElegida) as $detallePago)
                            <div class="col s2">{{(!is_null($detallePago->f_pago) ? date('d-m-Y', strtotime($detallePago->f_pago)) : '')}}</div>
                            <div class="col s2">{{(!is_null($detallePago->f_vencimiento) ? date('d-m-Y', strtotime($detallePago->f_vencimiento)) : '')}}</div>
                            <div class="col s2">{{$detallePago->TiposPago->descripcion}}</div>
                            <div class="col s2">{{$detallePago->estado}}</div>
                            <div class="col s4 right-align">{{$detallePago->importe}}</div>
                        @endforeach
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="card col s12">
        @paginacion (['elementos' => $pagos, 'path' => $path])
        @endpaginacion
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('select');
        var instances = M.FormSelect.init(elems);
    });

    $select = document.getElementById("tempSelect").onchange = function(){
        document.getElementById("nombre").value = null;
        document.getElementById("equipoSelect").value = null;
        /* document.getElementById("genSelect").value = null; */
        document.getElementById("tempForm").submit();
    };

    $select = document.getElementById("equipoSelect").onchange = function(){
        document.getElementById("nombre").value = null;
        document.getElementById("tempForm").submit();
    };

    /* $select = document.getElementById("genSelect").onchange = function(){
        document.getElementById("nombre").value = null;
        document.getElementById("tempForm").submit();
    }; */

    $select = document.getElementById("nombre").onkeyup = function(){
        var longitud = document.getElementById("nombre").value.length;
        if ((longitud < 1) || (longitud > 2)){
                document.getElementById("tempForm").submit();
            }
    };

    $(document).ready(function(){

        document.getElementById("nombre").selectionStart=document.getElementById("nombre").selectionEnd=document.getElementById("nombre").value.length;
        document.getElementById("nombre").focus();

        $('.collapsible').collapsible();
    });
</script>

@endsection
