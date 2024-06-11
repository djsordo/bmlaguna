@extends('layouts.app')

@section('content')

@include('common.success')

<div class="row">
    <div class="card-panel col s12 center">
        <h4>Listado de Preinscripciones</h4>
    </div>

    <div class="row">
        <div class="col s12">
                <form id="tempForm">
                    <div class="card col s9" style="height:200px">
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

                            <div class="col s6">
                                <div class="input-field">
                                    <i class="material-icons prefix">search</i>
                                    <input type="text" id="nombre" name="nombre" {{-- class="autocomplete" --}} autocomplete="off" value="{{$textoBusqueda}}">
                                    <label for="nombre">Nombre</label>
                                </div>
                            </div>

                            <div class="input-field col s2">
                                <select name="categoria_id" id="catSelect">
                                    <option value=""></option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" {{ ($categoria->id == $catActual_id) ? 'selected' : ''}}>{{ $categoria->descripcion}}</option>
                                    @endforeach
                                </select>
                                <label for="catSelect">Categoría</label>
                            </div>

                            <div class="input-field col s2">
                                <select name="genero_id" id="genSelect">
                                    <option value=""></option>
                                    @foreach ($generos as $genero)
                                        @if ($genero->descripcion != 'mixto')
                                            <option value="{{ $genero->id }}" {{ ($genero->id == $genActual_id) ? 'selected' : ''}}>{{ $genero->descripcion}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <label for="catSelect">Género</label>
                            </div>

                        </div>
                    </div>

                    <div class="card col s3" style="height:200px">
                        <div class="card-content">
                            <span class="card-title">Estado</span>

                                <div class="col s12">
                                    <label>
                                        <input class="with-gap" name="tipo" id="tipoPendientes" type="radio" value="Pendientes" @if ($tipoListado == 'Pendientes'){{'checked'}}@endif />
                                        <span>Pendientes {{$total["Pendientes"]}}</span>
                                    </label>
                                </div>
                                <div class="col s12">
                                    <label>
                                        <input class="with-gap" name="tipo" id="tipoPagadas" type="radio" value="Pagadas" @if ($tipoListado == 'Pagadas'){{'checked'}}@endif/>
                                        <span>Pagadas {{$total["Pagadas"]}}</span>
                                    </label>
                                </div>
                                <div class="col s12">
                                    <label>
                                        <input class="with-gap" name="tipo" id="tipoTodas" type="radio" value="Todas" @if ($tipoListado == 'Todas'){{'checked'}}@endif/>
                                        <span>Todas {{$total["Todas"]}}</span>
                                    </label>
                                </div>

                        </div>
                    </div>
                </form>

        </div>
    </div>

    <ul class="collapsible" data-collapsible="accordion">
        <li>
            <div class="collapsible-header">
                @if ($tipoListado == 'Pendientes')
                    <div class="flow-text">Pendientes de Pago</div>
                @elseif ($tipoListado == 'Pagadas')
                    <div class="flow-text">Pagadas</div>
                @else
                    <div class="flow-text">Todas</div>
                @endif
            </div>
        </li>
        <li>
            <div class="collapsible-header">
                <span class="col s1">Género</span>
                <span class="col s1">Pagado</span>
                <span class="col s2">Nº Preinscripción</span>
                <span class="col s2">Fecha Preinscripción</span>
                <span class="col s3">Nombre</span>
                <span class="col s1">Categoría</span>
                @if ($tipoListado != 'Todas')
                    <span class="col s2 center">Acciones</span>
                @endif
            </div>
        </li>
        @foreach ($preinscripciones as $preinscripcion)
            <li>
                <div class="collapsible-header">
                    @if ($preinscripcion->genero->descripcion == 'masculino')
                        <div class="col s1 center"><img width="30" src="/images/chico.png"></div>
                    @else
                        <div class="col s1 center"><img width="30" src="/images/chica.png"></div>
                    @endif

                    @if ($preinscripcion->estado == 'Pagado')
                        <div class="col s1 center"><i class="material-icons">check</i></div>
                    @else
                        <div class="col s1 center"><i class="material-icons"></i></div>
                    @endif

                    <span class="col s2">{{$preinscripcion->nPreinscripcion}}</span>
                    <span class="col s2">{{date('d-m-Y', strtotime($preinscripcion->f_preinscripcion))}}</span>
                    <span class="col s3">{{$preinscripcion->nombre. ' ' . $preinscripcion->apellido1 . ' ' . $preinscripcion->apellido2}}</span>
                    <span class="col s1">{{mostrar_categoria($preinscripcion->f_nacimiento, $tempElegida->temporada)->descripcion}}</span>

                        @if ($tipoListado == 'Pendientes')
                        <span class="col s1">
                            <a href="/preinscripciones/{{$preinscripcion->id}}/pagado" class="btn-small btn-flat waves-effect waves-light tooltipped" data-tooltip="marcar como pagado"><i class="material-icons">check</i></a>
                            {{-- <a href="/preinscripciones/{{$preinscripcion->id}}/prePago" class="btn-small btn-flat waves-effect waves-light tooltipped" data-tooltip="marcar como pagado"><i class="material-icons">check</i></a> --}}
                        </span>
                        <span class="col s1">
                            <form action="/preinscripciones/{{$preinscripcion->id}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-small btn-flat waves-effect waves-light tooltipped" data-tooltip="borrar"><i class="material-icons">delete</i></button>
                            </form>
                            {{-- <a href="/insAntiguos/{{$preinscripcion->miembro_id}}/SI" class="btn-small btn-flat waves-effect waves-light tooltipped" data-tooltip="enviar correo de inscripción"><i class="material-icons">attach_email</i> </a>                        </span> --}}
                            <a href="/preinsGenerica/{{$preinscripcion->id}}" class="btn-small btn-flat waves-effect waves-light tooltipped" data-tooltip="enviar correo de preinscripción"><i class="material-icons">attach_email</i> </a>                        </span>
                        @elseif ($tipoListado == 'Pagadas')
                        <span class="col s1">
                            <a href="/preinscripciones/{{$preinscripcion->id}}/deshacerPago" class="btn-small btn-flat waves-effect waves-light tooltipped" data-tooltip="Deshacer el pago"><i class="material-icons">undo</i></a>
                        </span>
                        <span class="col s1">
                            <a href="/pdf-preinscripcionPagada/{{$preinscripcion->id}}" class="btn-small btn-flat waves-effect waves-light tooltipped" data-tooltip="imprimir recibo"><i class="material-icons">print</i> </a>
                            <a href="/insGenerica/{{$preinscripcion->id}}" class="btn-small btn-flat waves-effect waves-light tooltipped" data-tooltip="enviar correo de inscripción"><i class="material-icons">attach_email</i> </a>
                            {{-- <a href="/insAntiguos/{{$preinscripcion->miembro_id}}/NO" class="btn-small btn-flat waves-effect waves-light tooltipped" data-tooltip="enviar correo de inscripción"><i class="material-icons">attach_email</i> </a> --}}
                        </span>
                        @endif
                    </span>
                </div>
                <div class="collapsible-body">
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
                            <div class="col s1">
                                <label for="importePago">Importe:</label><br>
                                <span id="importePago" class="black-text">{{ (!is_null($preinscripcion->importePago)) ? $preinscripcion->importePago : ' - ' }}</span>
                            </div>
                            <div class="col s2">
                                <label for="modalidad">Modalidad de pago:</label><br>
                                @if ($preinscripcion->modalidad_pago == 0)
                                    <span id="modalidad" class="black-text">New balance</span>
                                @elseif ($preinscripcion->modalidad_pago == 1)
                                    <span id="modalidad" class="black-text">Pago total</span>
                                @elseif ($preinscripcion->modalidad_pago == 2)
                                    <span id="modalidad" class="black-text">2 Cuotas</span>
                                @elseif ($preinscripcion->modalidad_pago == 3)
                                    <span id="modalidad" class="black-text">3 Cuotas</span>
                                @endif
                            </div>
                            <div class="col s2">
                                <label for="nif">N.I.F. :</label><br>
                                <span id="nif" class="black-text">{{ (!is_null($preinscripcion->nif)) ? $preinscripcion->nif : ' - ' }}</span>
                            </div>
                            <div class="col s3">
                                <label for="nom">Nombre:</label><br>
                                <span id="nom" class="black-text">{{ $preinscripcion->nombre.' '.$preinscripcion->apellido1.' '.$preinscripcion->apellido2 }}</span>
                            </div>
                        </div>

                        <div class="col s12 card">
                            <div class="col s3">
                                <label for="r1">Nombre del responsable:</label><br>
                                <span id="r1" class="black-text">{{ $preinscripcion->nombreR1.' '.$preinscripcion->apellido1R1.' '.$preinscripcion->apellido2R1 }}</span>
                            </div>
                            <div class="col s3">
                                <label for="r2">Nombre del responsable:</label><br>
                                <span id="r2" class="black-text">{{ $preinscripcion->nombreR2.' '.$preinscripcion->apellido1R2.' '.$preinscripcion->apellido2R2 }}</span>
                            </div>
                            <div class="col s2">
                                <label for="tel">Teléfono:</label><br>
                                <span id="tel" class="black-text">{{ $preinscripcion->telefono }}</span>
                            </div>
                            <div class="col s4">
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
                            <div class="col s8">
                                <label for="nomSerigrafia">Nombre para la serigrafía:</label><br>
                                <span id="nomSerigrafia" class="black-text">{{ $preinscripcion->nomSerigrafia }}</span>
                            </div>
                            <div class="col s4">
                                <label for="dorsal">Dorsal:</label><br>
                                <span id="dorsal" class="black-text">{{ $preinscripcion->dorsal }}</span>
                            </div>
                        </div>

                        <div class="col s12">
                            @if ($preinscripcion->socio == 'S')
                                <span class="flow-text">Desea ser socio</span>
                            @else
                                <span class="flow-text">No desea ser socio</span>
                            @endif
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>

    <div class="card col s12">
        @paginacion (['elementos' => $preinscripciones, 'path' => $path])
        @endpaginacion
    </div>
</div>

@include('footer')
<script>
/*     function quitarAcentos(cadena){
	    const acentos = {'á':'a','é':'e','í':'i','ó':'o','ú':'u','Á':'A','É':'E','Í':'I','Ó':'O','Ú':'U'};
	    return cadena.split('').map( letra => acentos[letra] || letra).join('').toString();
    } */

    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('select');
        var instances = M.FormSelect.init(elems);
    });

     document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.materialboxed');
        var instances = M.Materialbox.init(elems);
    });

    $select = document.getElementById("tempSelect").onchange = function(){
        document.getElementById("nombre").value = null;
        document.getElementById("catSelect").value = null;
        document.getElementById("genSelect").value = null;
        document.getElementById("tempForm").submit();
    };

    $select = document.getElementById("catSelect").onchange = function(){
        document.getElementById("nombre").value = null;
        document.getElementById("tempForm").submit();
    };

    $select = document.getElementById("genSelect").onchange = function(){
        document.getElementById("nombre").value = null;
        document.getElementById("tempForm").submit();
    };

    $select = document.getElementById("tipoPendientes").onchange = function(){
        document.getElementById("nombre").value = null;
        document.getElementById("catSelect").value = null;
        document.getElementById("genSelect").value = null;
        document.getElementById("tempForm").submit();
    };

    $select = document.getElementById("tipoPagadas").onchange = function(){
        document.getElementById("nombre").value = null;
        document.getElementById("catSelect").value = null;
        document.getElementById("genSelect").value = null;
        document.getElementById("tempForm").submit();
    };

    $select = document.getElementById("tipoTodas").onchange = function(){
        document.getElementById("nombre").value = null;
        document.getElementById("catSelect").value = null;
        document.getElementById("genSelect").value = null;
        document.getElementById("tempForm").submit();
    };

    $select = document.getElementById("nombre").onkeyup = function(){
        var longitud = document.getElementById("nombre").value.length;
        if ((longitud < 1) || (longitud > 2)){
                document.getElementById("tempForm").submit();
            }
    };

    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.tooltipped');
        var instances = M.Tooltip.init(elems);
    });

    $(document).ready(function(){
/*         console.log(window.datos);

        var datos = window.datos;
        var datosConv = {};

        for (var i = 0; i < datos.length; i++){
            var nombre = quitarAcentos(datos[i].nombre);
            var apellido1 = quitarAcentos(datos[i].apellido1);
            if (datos[i].apellido2 == null){
                var apellido2 = "";
            }
            else {
                var apellido2 = quitarAcentos(datos[i].apellido2);
            }

            datosConv[nombre + " " + apellido1 + " " + apellido2] = null;
        }

        console.log(datosConv);

        $('input.autocomplete').autocomplete({
            data: datosConv,
            minLength: 3,
        }); */

        document.getElementById("nombre").selectionStart=document.getElementById("nombre").selectionEnd=document.getElementById("nombre").value.length;
        document.getElementById("nombre").focus();

        $('.collapsible').collapsible();
    });
</script>

@endsection
