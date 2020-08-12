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
    {{--         <li>
                <div class="collapsible-header">
                    @if ($tipoListado == 'Pendientes')
                        <div class="flow-text">Pendientes de Pago</div>
                    @elseif ($tipoListado == 'Pagadas')
                        <div class="flow-text">Pagadas</div>
                    @else
                        <div class="flow-text">Todas</div>
                    @endif
                </div>
            </li> --}}
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
    {{--                     @if ($preinscripcion->genero->descripcion == 'masculino')                        
                            <div class="col s1 center"><img width="30" src="/images/chico.png"></div>
                        @else
                            <div class="col s1 center"><img width="30" src="/images/chica.png"></div>
                        @endif

                        @if ($preinscripcion->estado == 'Pagado')
                            <div class="col s1 center"><i class="material-icons">check</i></div>
                        @else
                            <div class="col s1 center"><i class="material-icons"></i></div>
                        @endif
    --}}
                        {{-- <span class="col s2">{{date('d-m-Y', strtotime($pago->f_pago))}}</span> --}}
                        <span class="col s8">{{$pago->miembro->nombre. ' ' . $pago->miembro->apellido1 . ' ' . $pago->miembro->apellido2}}</span>
                        {{-- <span class="col s2">{{$pago->tiposPago->descripcion}}</span> --}}
                        <span class="col s2 right-align">{{$pago->sumPagado()}}</span>
                        <span class="col s2 right-align">{{$pago->miembro->aPagar($tempElegida)}}</span>
                        
    {{--                         @if ($tipoListado == 'Pendientes')
                            <span class="col s1">
                                <a href="/preinscripciones/{{$preinscripcion->id}}/pagado" class="btn-small btn-flat waves-effect waves-light tooltipped" data-tooltip="marcar como pagado"><i class="material-icons">check</i></a>
                            </span>
                            <span class="col s1">
                                <form action="/preinscripciones/{{$preinscripcion->id}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-small btn-flat waves-effect waves-light tooltipped" data-tooltip="borrar"><i class="material-icons">delete</i></button>   
                                </form>
                            </span>
                            @elseif ($tipoListado == 'Pagadas')
                            <span class="col s1">
                                <a href="/preinscripciones/{{$preinscripcion->id}}/deshacerPago" class="btn-small btn-flat waves-effect waves-light tooltipped" data-tooltip="Deshacer el pago"><i class="material-icons">undo</i></a>
                            </span>
                            <span class="col s1">
                                <a href="/pdf-preinscripcionPagada/{{$preinscripcion->id}}" class="btn-small btn-flat waves-effect waves-light tooltipped" data-tooltip="imprimir recibo"><i class="material-icons">print</i> </a>
                            </span>
                            @endif
                        </span>--}} 
                    </div>
                    <div class="collapsible-body row">
                        <div class="col s12">
                            <div class="col s4"><label>Fecha de Pago</label></div>
                            <div class="col s4"><label>Tipo de Pago</label></div>
                            <div class="col s4 right-align"><label>Importe</label></div>
                        </div>

                        <div class="col s12 card">
                        @foreach ($pago->miembro->listaPagos($tempElegida) as $detallePago)
                            <div class="col s4">{{date('d-m-Y', strtotime($detallePago->f_pago) )}}</div>
                            <div class="col s4">{{$detallePago->TiposPago->descripcion}}</div>
                            <div class="col s4 right-align">{{$detallePago->importe}}</div>
                        @endforeach
                        </div>
                    </div>
    {{--                 <div class="collapsible-body">
                        <div class="row">
                            <div class="col s12 card">
                                <div class="col s2">
                                    <label for="f_nacimiento">Fecha de nacimiento:</label><br>
                                    <span id="f_nacimiento" class="black-text">{{ (!is_null($preinscripcion->f_nacimiento)) ? date('d-m-Y', strtotime($preinscripcion->f_nacimiento) ) : ' - ' }}</span>
                                </div>
                                <div class="col s2">
                                    <label for="f_pago">Fecha de pago:</label><br>
                                    <span id="f_pago" class="black-text">{{ (!is_null($preinscripcion->f_pago)) ? date('d-m-Y', strtotime($preinscripcion->f_pago) ) : ' - ' }}</span>
                                </div>
                                <div class="col s2">
                                    <label for="nif">N.I.F. :</label><br>
                                    <span id="nif" class="black-text">{{ (!is_null($preinscripcion->nif)) ? $preinscripcion->nif : ' - ' }}</span>
                                </div>
                                <div class="col s4">
                                    <label for="nom">Nombre:</label><br>
                                    <span id="nom" class="black-text">{{ $preinscripcion->nombre.' '.$preinscripcion->apellido1.' '.$preinscripcion->apellido2 }}</span>
                                </div>        
                            </div>
                            
                            <div class="col s12 card">
                                <div class="col s4">
                                    <label for="r1">Nombre del responsable:</label><br>
                                    <span id="r1" class="black-text">{{ $preinscripcion->nombreR1.' '.$preinscripcion->apellido1R1.' '.$preinscripcion->apellido2R1 }}</span>
                                </div>        
                                <div class="col s4">
                                    <label for="r2">Nombre del responsable:</label><br>
                                    <span id="r2" class="black-text">{{ $preinscripcion->nombreR2.' '.$preinscripcion->apellido1R2.' '.$preinscripcion->apellido2R2 }}</span>
                                </div>        
                                <div class="col s2">
                                    <label for="tel">Teléfono:</label><br>
                                    <span id="tel" class="black-text">{{ $preinscripcion->telefono }}</span>
                                </div>        
                                <div class="col s2">
                                    <label for="email">Correo electrónico:</label><br>
                                    <span id="email" class="black-text">{{ $preinscripcion->email }}</span>
                                </div>        
                            </div>

                            <div class="col s5 card">
                                <div class="col s8">
                                    <label for="direccion">Dirección:</label><br>
                                    <span id="direccion" class="black-text">{{ $preinscripcion->domicilio }}</span>
                                </div>        
                                <div class="col s4">
                                    <label for="c_postal">Código postal:</label><br>
                                    <span id="c_postal" class="black-text">{{ $preinscripcion->c_postal }}</span>
                                </div>        
                                <div class="col s6">
                                    <label for="localidad">Localidad:</label><br>
                                    <span id="localidad" class="black-text">{{ $preinscripcion->localidad }}</span>
                                </div>        
                                <div class="col s6">
                                    <label for="municipio">Municipio:</label><br>
                                    <span id="municipio" class="black-text">{{ $preinscripcion->municipio }}</span>
                                </div>        
                            </div>

                            <div class="col s5 card right">
                                <div class="col s12">
                                    <label for="centro">centro educativo:</label><br>
                                    <span id="centro" class="black-text">{{ $preinscripcion->centroEducativo }}</span>
                                </div>        
                            </div>

                            <div class="col s12">
                                @if ($preinscripcion->socio == 'S')                                
                                    <span class="flow-text">Desea ser socio</span>
                                @else
                                    <span class="flow-text">No desea ser socio</span>
                                @endif
                            </div>
                        </div> --}}
                    {{-- </div> --}}
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