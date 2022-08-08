@extends('layouts.app')

@section('content')

@include('common.success')


<div class="section">
    <div class="row">
        <div class="section valign-wrapper">
            <div class="col s7">
                <span><h2>Lista de Equipos</h2></span>
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

        <div>
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
                                                    <div class="secondary-content">
                                                        <a href="{{ route('pdf-certFedeRecoEquipo', compact('equipo')) }}"><i class="material-icons green-text">print</i></a>
                                                        <a href="#exportMiembros" class="modal-trigger tooltipped" data-tooltip="Listado Excel de los miembros del equipo"><img src="/images/excel.png" width="22px" onClick="pasaEquipo({{$equipo->id}})"></a>
                                                        <a href="/equipos/{{$equipo->id}}/edit"><i class="material-icons green-text">edit</i></a>
                                                        <a href="{{route ('preinsEquipo', [$equipo->id])}}"><i class="material-icons green-text">local_post_office</i></a>
                                                    </div>
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
    </div>
</div>

<div id="exportMiembros" class="modal modal-fixed-footer">
    <form id="excelForm" action="/export-miembros">
        <div class="modal-content">
            <span class="card col s12 flow-text center">Listado EXCEL de miembros del equipo</span>
            {{-- Árbol de Campos --}}
            <ul class="col s6 card-panel hoverable offset-s3">
                <span class="card-title flow-text">Datos a mostrar</span>
                {{-- Datos Personales --}}
                <li style="margin:2%">
                    <div class="valign-wrapper">
                        <i class="material-icons" id="expDatosP" style="cursor: pointer">add</i><i class="material-icons" id="collDatosP" style="cursor: pointer">remove</i>
                        <span><b>Datos Personales</b></span>
                        <div style="margin-left: 5%">
                            <label>
                                <input type="checkbox" id="checkDatosP"/>
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <ul id="datosPersonales" style="margin-left: 10%">
                            <li>
                                <label>
                                    <input type="checkbox" id="checkNombre" name="checkNombre"/>
                                    <span class="black-text">Nombre</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox" id="checkNIF" name="checkNIF"/>
                                    <span class="black-text">N.I.F.</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox" id="checkFNac" name="checkFNac"/>
                                    <span class="black-text">Fecha de Nacimiento</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox" id="checkGenero" name="checkGenero"/>
                                    <span class="black-text">Género</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox" id="checkCentro" name="checkCentro"/>
                                    <span class="black-text">Centro Educativo</span>
                                </label>
                            </li>
                        </ul>    
                    </li>
                    {{-- Fin datos Personales --}}
                    {{-- Domicilio --}}
                <li style="margin:2%">
                    <div class="valign-wrapper"><i class="material-icons" id="expDireccion" style="cursor: pointer">add</i><i class="material-icons" id="collDireccion" style="cursor: pointer">remove</i><span><b>Dirección Postal</b></span>
                        <div style="margin-left: 5%">
                            <label>
                                <input type="checkbox" id="checkDireccion"/>
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <ul id="direccion" style="margin-left: 10%">
                            <li>
                                <label>
                                    <input type="checkbox" id="checkDomicilio" name="checkDomicilio"/>
                                    <span class="black-text">Domicilio</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox" id="checkLocalidad" name="checkLocalidad"/>
                                    <span class="black-text">Localidad</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox" id="checkProvincia" name="checkProvincia"/>
                                    <span class="black-text">Provincia</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox" id="checkCPostal" name="checkCPostal"/>
                                    <span class="black-text">Código Postal</span>
                                </label>
                            </li>
                        </ul>    
                    </li>
                    {{-- Fin Domicilio --}}
                    {{-- Contactos --}}
                <li style="margin:2%">
                    <div class="valign-wrapper"><i class="material-icons" id="expContactos" style="cursor: pointer">add</i><i class="material-icons" id="collContactos" style="cursor: pointer">remove</i><span><b>Formas de Contacto</b></span>
                        <div style="margin-left: 5%">
                            <label>
                                <input type="checkbox" id="checkContactos"/>
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <ul id="contactos" style="margin-left: 10%">
                        <li>
                            <label>
                                <input type="checkbox" id="checkTelefonos" name="checkTelefonos"/>
                                <span class="black-text">Telefonos</span>
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="checkbox" id="checkEmails" name="checkEmails"/>
                                <span class="black-text">Correo Electrónico</span>
                            </label>
                        </li>
                    </ul>    
                </li>
                        {{-- Fin Contactos --}}
                        {{-- Familiares --}}
                <li style="margin:2%">
                    <div class="valign-wrapper" style="margin-left: 24px"><span><b>Familiares</b></span>
                        <div style="margin-left: 5%">
                            <label>
                                <input type="checkbox" id="checkFamiliares" name="checkFamiliares"/>
                                <span></span>
                            </label>
                        </div>
                    </div>
                </li>
                    {{-- Fin Familiares --}}
                    {{-- Categoría --}}
                <li style="margin:2%">
                    <div class="valign-wrapper" style="margin-left: 24px"><span><b>Categoría</b></span>
                        <div style="margin-left: 5px">
                            <label>
                                <input type="checkbox" id="checkCategoria" name="checkCategoria"/>
                                <span></span>
                            </label>
                        </div>
                    </div>
                </li>
                    {{-- Fin Categoría --}}
                    {{-- Equipo --}}
                <li style="margin:2%">
                    <div class="valign-wrapper"><i class="material-icons" id="expEquipo" style="cursor: pointer">add</i><i class="material-icons" id="collEquipo" style="cursor: pointer">remove</i><span><b>Equipo</b></span>
                        <div style="margin-left: 5px">
                            <label>
                                <input type="checkbox" id="checkEquipo"/>
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <ul id="equipo" style="margin-left: 25px">
                        <li>
                            <label>
                                <input type="checkbox" id="checkNomEquipo" name="checkNomEquipo"/>
                                <span class="black-text">Denominación del Equipo</span>
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="checkbox" id="checkFuncion" name="checkFuncion"/>
                                <span class="black-text">Función dentro del equipo</span>
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="checkbox" id="checkDorsal" name="checkDorsal"/>
                                <span class="black-text">Dorsal</span>
                            </label>
                        </li>
                    </ul>    
                </li>
                    {{-- Fin Equipo --}}
                    {{-- Estado de la Preinscripción --}}
                <li style="margin:2%">
                    <div class="valign-wrapper" style="margin-left: 24px"><span><b>Estado de la Preinscripción</b></span>
                        <div style="margin-left: 5px">
                            <label>
                                <input type="checkbox" id="checkPreinscripcion" name="checkPreinscripcion"/>
                                <span></span>
                            </label>
                        </div>
                    </div>
                </li>
                    {{-- Fin Estado de la Preinscripción --}}
                        {{-- Pagos --}}
                <li style="margin:2%">
                    <div class="valign-wrapper"><i class="material-icons" id="expPagos" style="cursor: pointer">add</i><i class="material-icons" id="collPagos" style="cursor: pointer">remove</i><span><b>Pagos</b></span>
                        <div style="margin: 5px">
                            <label>
                                <input type="checkbox" id="checkPagos"/>
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <ul id="pagos" style="margin-left: 25px">
                        <li>
                            <label>
                                <input type="checkbox" id="checkPagado" name="checkPagado"/>
                                <span class="black-text">Pagado</span>
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="checkbox" id="checkTotalPagar" name="checkTotalPagar"/>
                                <span class="black-text">Total a Pagar</span>
                            </label>
                        </li>
                    </ul>    
                </li>
                    {{-- Fin Pagos --}}
            </ul>
        </div>
        <div class="modal-footer">
            <button class="btn modal-close waves-effect waves-green btn-flat" type="submit">Aceptar</button>
        </div>    

        <input type="text" id="excelTemp_id" name="excelTemp_id" value="{{$tempActual_id}}" hidden>
        <input type="text" id="excelEqui_id" name="excelEqui_id" hidden>
        <input type="text" id="excelCat_id" name="excelCat_id" value="{{null}}" hidden>
        <input type="text" id="excelGen_id" name="excelGen_id" value="{{null}}" hidden>
        <input type="text" id="excelNombre" name="excelNombre" autocomplete="off" value="{{null}}" hidden>
        <input type="text" id="excelBaja" name="excelBaja" autocomplete="off" value="{{null}}" hidden>
        
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('select');
        var instances = M.FormSelect.init(elems);
    });

    $select = document.getElementById("tempSelect").onchange = function(){
        document.getElementById("tempForm").submit();
    };

    document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.modal');
            var instances = M.Modal.init(elems, {opacity: 0.5});
    });

    function pasaEquipo(id){
        document.getElementById("excelEqui_id").value = id;
    }

    /* Árbol de checkboxes */

    /* Datos Personales */
    $select = document.getElementById("checkDatosP").onchange = function(){
        if (document.getElementById("checkDatosP").checked == false){
            document.getElementById("checkNombre").checked = false;
            document.getElementById("checkNIF").checked = false;
            document.getElementById("checkFNac").checked = false;
            document.getElementById("checkGenero").checked = false;
            document.getElementById("checkCentro").checked = false;
        }
        else{
            document.getElementById("checkNombre").checked = true;
            document.getElementById("checkNIF").checked = true;
            document.getElementById("checkFNac").checked = true;
            document.getElementById("checkGenero").checked = true;
            document.getElementById("checkCentro").checked = true;
        }
    };

    $select = document.getElementById("expDatosP").onclick = function(){
        console.log(document.getElementById("expDatosP"));
        document.getElementById("datosPersonales").hidden = false;
        document.getElementById("expDatosP").innerHTML = "";
        document.getElementById("collDatosP").innerHTML = "remove";
    }

    $select = document.getElementById("collDatosP").onclick = function(){
        document.getElementById("datosPersonales").hidden = true;
        document.getElementById("expDatosP").innerHTML = "add";
        document.getElementById("collDatosP").innerHTML = "";
    }
    /* Fin datos Personales */
    /* Domicilio */
    $select = document.getElementById("checkDireccion").onchange = function(){
        if (document.getElementById("checkDireccion").checked == false){
            document.getElementById("checkDomicilio").checked = false;
            document.getElementById("checkLocalidad").checked = false;
            document.getElementById("checkProvincia").checked = false;
            document.getElementById("checkCPostal").checked = false;
        }
        else{
            document.getElementById("checkDomicilio").checked = true;
            document.getElementById("checkLocalidad").checked = true;
            document.getElementById("checkProvincia").checked = true;
            document.getElementById("checkCPostal").checked = true;
        }
    };

    $select = document.getElementById("expDireccion").onclick = function(){
        console.log(document.getElementById("expDireccion"));
        document.getElementById("direccion").hidden = false;
        document.getElementById("expDireccion").innerHTML = "";
        document.getElementById("collDireccion").innerHTML = "remove";
    }

    $select = document.getElementById("collDireccion").onclick = function(){
        document.getElementById("direccion").hidden = true;
        document.getElementById("expDireccion").innerHTML = "add";
        document.getElementById("collDireccion").innerHTML = "";
    }
    /* Fin Domicilio */
    /* Contactos */
    $select = document.getElementById("checkContactos").onchange = function(){
        if (document.getElementById("checkContactos").checked == false){
            document.getElementById("checkTelefonos").checked = false;
            document.getElementById("checkEmails").checked = false;
        }
        else{
            document.getElementById("checkTelefonos").checked = true;
            document.getElementById("checkEmails").checked = true;
        }
    };

    $select = document.getElementById("expContactos").onclick = function(){
        console.log(document.getElementById("expContactos"));
        document.getElementById("contactos").hidden = false;
        document.getElementById("expContactos").innerHTML = "";
        document.getElementById("collContactos").innerHTML = "remove";
    }

    $select = document.getElementById("collContactos").onclick = function(){
        document.getElementById("contactos").hidden = true;
        document.getElementById("expContactos").innerHTML = "add";
        document.getElementById("collContactos").innerHTML = "";
    }
    /* Fin Contactos */
    /* Equipo */
    $select = document.getElementById("checkEquipo").onchange = function(){
        if (document.getElementById("checkEquipo").checked == false){
            document.getElementById("checkNomEquipo").checked = false;
            document.getElementById("checkFuncion").checked = false;
            document.getElementById("checkDorsal").checked = false;
        }
        else{
            document.getElementById("checkNomEquipo").checked = true;
            document.getElementById("checkFuncion").checked = true;
            document.getElementById("checkDorsal").checked = true;
        }
    };

    $select = document.getElementById("expEquipo").onclick = function(){
        console.log(document.getElementById("expEquipo"));
        document.getElementById("equipo").hidden = false;
        document.getElementById("expEquipo").innerHTML = "";
        document.getElementById("collEquipo").innerHTML = "remove";
    }

    $select = document.getElementById("collEquipo").onclick = function(){
        document.getElementById("equipo").hidden = true;
        document.getElementById("expEquipo").innerHTML = "add";
        document.getElementById("collEquipo").innerHTML = "";
    }
    /* Fin Equipo */
    /* Pagos */
    $select = document.getElementById("checkPagos").onchange = function(){
        if (document.getElementById("checkPagos").checked == false){
            document.getElementById("checkPagado").checked = false;
            document.getElementById("checkTotalPagar").checked = false;
        }
        else{
            document.getElementById("checkPagado").checked = true;
            document.getElementById("checkTotalPagar").checked = true;
        }
    };

    $select = document.getElementById("expPagos").onclick = function(){
        console.log(document.getElementById("expPagos"));
        document.getElementById("pagos").hidden = false;
        document.getElementById("expPagos").innerHTML = "";
        document.getElementById("collPagos").innerHTML = "remove";
    }

    $select = document.getElementById("collPagos").onclick = function(){
        document.getElementById("pagos").hidden = true;
        document.getElementById("expPagos").innerHTML = "add";
        document.getElementById("collPagos").innerHTML = "";
    }
    /* Fin Equipo */

    $(document).ready(function(){
        
        /* Inicialización del Árbol */
        /* Datos Personales */
        document.getElementById("expDatosP").innerHTML = "add";
        document.getElementById("collDatosP").innerHTML = "";
        document.getElementById("datosPersonales").hidden = true;
        document.getElementById("checkDatosP").checked = true;
        document.getElementById("checkNombre").checked = true;
        document.getElementById("checkNIF").checked = false;
        document.getElementById("checkFNac").checked = true;
        document.getElementById("checkGenero").checked = false;
        document.getElementById("checkCentro").checked = false;
        /* Fin Datos Personales */
        /* Domicilio */
        document.getElementById("expDireccion").innerHTML = "add";
        document.getElementById("collDireccion").innerHTML = "";
        document.getElementById("direccion").hidden = true;
        document.getElementById("checkDireccion").checked = false;
        document.getElementById("checkDomicilio").checked = false;
        document.getElementById("checkLocalidad").checked = false;
        document.getElementById("checkProvincia").checked = false;
        document.getElementById("checkCPostal").checked = false;
        /* Fin Domicilio */
        /* Contactos */
        document.getElementById("expContactos").innerHTML = "add";
        document.getElementById("collContactos").innerHTML = "";
        document.getElementById("contactos").hidden = true;
        document.getElementById("checkContactos").checked = false;
        document.getElementById("checkTelefonos").checked = false;
        document.getElementById("checkEmails").checked = false;
        /* Fin Contactos */
        /* Familiares */
        document.getElementById("checkFamiliares").checked = false;
        /* Fin Familiares */
        /* Categoría */
        document.getElementById("checkCategoria").checked = false;
        /* Fin Categoría */
        /* Equipo */
        document.getElementById("expEquipo").innerHTML = "add";
        document.getElementById("collEquipo").innerHTML = "";
        document.getElementById("equipo").hidden = true;
        document.getElementById("checkEquipo").checked = true;
        document.getElementById("checkNomEquipo").checked = false;
        document.getElementById("checkFuncion").checked = true;
        document.getElementById("checkDorsal").checked = true;
        /* Fin Equipo */
        /* Estado de la Preinscripcion */
        document.getElementById("checkPreinscripcion").checked = false;
        /* Fin Estado de la Preinscripcion */
        /* Pagos */
        document.getElementById("expPagos").innerHTML = "add";
        document.getElementById("collPagos").innerHTML = "";
        document.getElementById("pagos").hidden = true;
        document.getElementById("checkPagos").checked = false;
        document.getElementById("checkPagado").checked = false;
        document.getElementById("checkTotalPagar").checked = false;
        /* Fin Pagos */
    });

</script>
@endsection