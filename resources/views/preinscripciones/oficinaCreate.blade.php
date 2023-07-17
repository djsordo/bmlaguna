@extends('layouts.app')

@section('content')

<script src='/js/miembros.js'></script>

@include('common.success')

<div class="row">
    <div class="col s4">
        <img src="/images/escudo.png" alt="Balonmano Laguna" class="responsive-img">
    </div>
    <div class="col s8">
        <h2>CLUB BALONMANO LAGUNA</h2>
    </div>
    <div class="col s8">
        <h3>Formulario de Preinscripción</h3>
        <h4>Temporada {{$temporada->descripcion}}</h4>
    </div>
</div>

    <div class="section">
        <div class="row">
            <form method="POST" action="/preinscripcionOficina"  class="col s12" enctype="multipart/form-data">
                @csrf

                    <div class="row card-panel">
                        <div class="section row">
                            <span class="card-title col s8"><strong class="flow-text">Datos Personales</strong></span>
                        </div>

                        <div class="input-field col s4">
                            <input type="text" id="nif" name="nif" class="validate" pattern="(([X-Z]{1})([-]?)(\d{7})([-]?)([A-Z]{1}))|((\d{8})([-]?)([A-Z]{1}))"  value="{{ (!is_null($miembro)) ? $miembro->nif : '' }}">
                            <label for="nif">N.I.F. :</label>
                        </div>

                        <div class="input-field col s4">
                            <input type="date" id="f_nacimiento" name="f_nacimiento" class="validate" required value="{{ (!is_null($miembro)) ? $miembro->f_nacimiento : '' }}">
                            <label for="f_nacimiento">Fecha de nacimiento: *</label>
                        </div>

                        <div class="input-field col s4">
                            <label style = "position: absolute; top: -26px; font-size: 0.8rem">Género: *</label>
                            <select id="genero_id" name="genero_id" placeholder="Género" class="validate" required>
                                <option value="" selected>-- Elige un género --</option>
                                @foreach ($generos as $genero)
                                    <option value="{{ $genero->id }}" @if (!is_null($miembro)) {{ ($genero->id == $miembro->genero_id) ? 'selected' : '' }} @endif >{{ $genero->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-field col s4">
                            <input type="text" id="nombre" name="nombre" class="validate" required  value="{{ (!is_null($miembro)) ? $miembro->nombre : '' }}">
                            <label for="nombre">Nombre: *</label>
                        </div>

                        <div class="input-field col s4">
                            <input type="text"id="apellido1" name="apellido1" class="validate" required value="{{ (!is_null($miembro)) ? $miembro->apellido1 : '' }}">
                            <label for="apellido1">Primer apellido: *</label>
                        </div>
                        <div class="input-field col s4">
                            <input type="text"id="apellido2" name="apellido2" class="validate" value="{{ (!is_null($miembro)) ? $miembro->apellido2 : '' }}">
                            <label for="apellido2">Segundo apellido:</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text"id="centroEducativo" name="centroEducativo" class="validate" required value="{{ (!is_null($miembro)) ? $miembro->centroEducativo : '' }}">
                            <label for="centroEducativo">Centro Educativo: *</label>
                        </div>
                        <div class="input-field col s4">
                            <input type="text"id="nomSerigrafia" name="nomSerigrafia" class="validate" value="{{ (!is_null($miembro)) ? $miembro->nomSerigrafia : '' }}">
                            <label for="nomSerigrafia">Nombre para la serigrafía:</label>
                        </div>
                        <div class="input-field col s2">
                            <input type="text" id="dorsal" name="dorsal" class="validate" value="{{ (!is_null($miembro)) ? $miembro->dorsal : '' }}" readonly>
                            <label for="dorsal">Dorsal:</label>
                        </div>
{{--                         <div class="input-field col s2">
                            <label style = "position: absolute; top: -26px; font-size: 0.8rem">Dorsal</label>
                            <select id="dorsal" name="dorsal" placeholder="Dorsal" @if (!is_null($miembro)) {{ (!is_null($miembro->dorsal)) ? 'readonly' : '' }} @endif>
                                <option value="" selected>-- Elige un dorsal --</option>
                                @foreach ($dorsales as $dorsal)
                                    <option value="{{ $dorsal }}" @if (!is_null($miembro)) {{ ($dorsal == $miembro->dorsal) ? 'selected' : '' }} @endif >{{ $dorsal }}</option>
                                @endforeach
                            </select>
                        </div>
 --}}
                    </div>


                @ubicacion (['miembro' => $miembro])
                @endubicacion

                <div class="row card-panel">
                    <div class="row section">
                        <span class="card-title col s12"><strong class="flow-text">Familiares</strong></span>
                    </div>


                    <div class="row">
                        <div class="flow-text">Padre/Madre o Tutor</div>
                        <div class="valign-wrapper">
                            <div class="input-field col s4">
                                <input type="text"id="nombreR1" name="nombreR1" class="validate" required value="{{ (!is_null($resp1)) ? $resp1->nombre : '' }}">
                                <label for="nombreR1">Nombre: *</label>
                            </div>

                            <div class="input-field col s4">
                                <input type="text"id="apellido1R1" name="apellido1R1" class="validate" required value="{{ (!is_null($resp1)) ? $resp1->apellido1 : '' }}">
                                <label for="apellido1R1">Primer apellido: *</label>
                            </div>
                            <div class="input-field col s4">
                                <input type="text"id="apellido2R1" name="apellido2R1" class="validate" value="{{ (!is_null($resp1)) ? $resp1->apellido2 : '' }}">
                                <label for="apellido2R1">Segundo apellido:</label>
                            </div>
                        </div>

                        <div class="flow-text">Otro</div>
                        <div class="valign-wrapper">
                            <div class="input-field col s4">
                                <input type="text"id="nombreR2" name="nombreR2" class="validate" value="{{ (!is_null($resp2)) ? $resp2->nombre : '' }}">
                                <label for="nombreR2">Nombre:</label>
                            </div>

                            <div class="input-field col s4">
                                <input type="text"id="apellido1R2" name="apellido1R2" class="validate" value="{{ (!is_null($resp2)) ? $resp2->apellido1 : '' }}">
                                <label for="apellido1R2">Primer apellido:</label>
                            </div>
                            <div class="input-field col s4">
                                <input type="text"id="apellido2R2" name="apellido2R2" class="validate"  value="{{ (!is_null($resp2)) ? $resp2->apellido2 : '' }}">
                                <label for="apellido2R2">Segundo apellido:</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row card-panel">
                    <div class="section row">
                        <span class="card-title col s12"><strong class="flow-text">Formas de contacto</strong></span>
                    </div>
                    <div class="valign-wrapper">
                        <div class="input-field col s6">
                            <input type="tel" id="telefono" name="telefono" class="validate" value="{{ (!is_null($telefono)) ? $telefono->telefono : '' }}">
                            <label for="telefono">Telefono:</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="tel" id="telefonoFijo" name="telefonoFijo" class="validate">
                            <label for="telefono">Teléfono Fijo:</label>
                        </div>
                    </div>
                    <div class="valign-wrapper">
                        <div class="input-field col s6">
                            <input type="tel" id="telefonoOtro" name="telefonoOtro" class="validate">
                            <label for="telefono">Otro teléfono:</label>
                        </div>

                        <div class="input-field col s6">
                            <input type="email" id="email" name="email" class="validate" required value="{{ (!is_null($email)) ? $email->email : '' }}">
                            <label for="email">Correo Electrónico: *</label>
                        </div>
                    </div>
                </div>

                <div class="row card-panel">
                    <div class="input-field col s12">
                        <input type="text" id="obsEnfermedad" name="obsEnfermedad" class="validate">
                        <label for="obsEnfermedad">¿Sufre algún tipo de enfermedad o discapacidad?</label>
                    </div>
                    <div class="input-field col s12">
                        <input type="text" id="obsAlergia" name="obsAlergia" class="validate">
                        <label for="obsAlergia">¿Tiene alergia a algún medicamento?</label>
                    </div>
                    <div class="input-field col s12">
                        <input type="text" id="obsOtras" name="obsOtras" class="validate">
                        <label for="obsOtras">Otras observaciones</label>
                    </div>
                </div>
                <div class="row card-panel">
                    <div class="row section">
                        <span class="card-title col s12"><strong class="flow-text">AUTORIZACIÓN PARA PARTICIPAR EN LA ACTIVIDAD</strong></span>
                    </div>
                    <div class="col s12">
                        <p align="justify">En calidad de Madre/Padre/Tutor certifico que estos datos son ciertos y para el niño/a arriba inscrito</p>
                    </div>

                    <div class="col s12">
                        <div class="col s10">_</div>
                        <div class="col s1">
                            Sí
                        </div>
                        <div class="col s1">
                            No
                        </div>
                    </div>

                    <div class="col s12">
                        <div class="col s10">
                            autorizo a que el participante salga en videos o fotografías de la actividad (el uso de las mismas será lícito y exclusivamente de difusión o promoción de la actividad del club).
                        </div>
                        <div class="col s1">
                            <label>
                                <input name="autorizacion" type="radio" value="S" required/>
                                <span></span>
                            </label>
                        </div>
                        <div class="col s1">
                            <label>
                                <input name="autorizacion" type="radio" value="N" required/>
                                <span></span>
                            </label>

                        </div>
                    </div>

                    <div class="col s12">
                        <div class="col s10">
                            quiero que se nos considere como familia socia del club, para participar en las decisiones asamblearias y obtener descuento de patrocinadores.
                        </div>
                        <div class="col s1">
                            <label>
                                <input name="socio" type="radio" value="S" required/>
                                <span></span>
                            </label>
                        </div>
                        <div class="col s1">
                            <label>
                                <input name="socio" type="radio" value="N" required/>
                                <span></span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row card-panel">
                    <div class="row section">
                        <span class="card-title col s12"><strong class="flow-text">OPCIONES DE PAGO</strong></span>
                    </div>

                    <div class="col s12" hidden>
                        <div class="col s11">
                            Modalidad de pago en 3 recibos (ver tabla de cuotas para la temporada 23-24 en este <a href="{{ route('pdf-cuotas', compact('temporada')) }}">enlace</a>).
                        </div>
                        <div class="col s1">
                            <label>
                                <input name="importePago" type="radio" value="3" required/>
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="col s12">
                        <div class="col s11">
                            Modalidad de pago en 2 recibos (ver tabla de cuotas para la temporada 23-24 en este <a href="{{ route('pdf-cuotas', compact('temporada')) }}">enlace</a>).
                        </div>
                        <div class="col s1">
                            <label>
                                <input name="importePago" type="radio" value="2" required/>
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="col s12">
                        <div class="col s11">
                            Modalidad de pago en 1 recibo (ver tabla de cuotas para la temporada 23-24 en este <a href="{{ route('pdf-cuotas', compact('temporada')) }}">enlace</a>).
                        </div>
                        <div class="col s1">
                            <label>
                                <input name="importePago" type="radio" value="1" required/>
                                <span></span>
                            </label>
                        </div>
                    </div>

                    <div class="col s12">
                        <p class="flow-text">AVISO:</p>
                        <p align="justify">Los <b>pagos de los recibos se deben realizar convenientemente y en su fecha</b>. De no ser así, se procederá al bloqueo de la ficha federativa del jugador hasta que se solucione el problema.</p>
                        <p align="justify">Para poder solventar cualquier situación especial o incidencia con respecto al pago de la cuota, contactar con el Club por correo a la dirección bmnlaguna@gmail.com, o personalmente en la oficina.</p>
                        <p align="justify">La <b>oficina se sitúa</b> en el Polideportivo Municipal de Laguna de Duero (Avd de las Salinas nº3), y abre los miércoles y viernes de 19 a 21 horas.</p></br>
                    </div>

                    <div class="col s12">
                        <p class="flow-text">AVISO DE CONFIDENCIALIDAD:</p>
                        <p align="justify">según lo dispuesto en la legislación en materia de protección de datos y por el RGPD UE 2016/679 de la LSSI (34/2002), garantizamos la confidencialidad de sus datos los cuales serán incluidos en un fichero de nuestra propiedad. Usted podrá ejercitar sus derechos de acceso, rectificación, cancelación o supresión, oposición, limitación del tratamiento o portabilidad de sus datos comunicándose por correo electrónico a <b>bmlagunadircc@gmail.com</b>. Igualmente tiene usted derecho a presentar una reclamación ante la Agencia de Protección de Datos.</p>
                        <p align="justify">Así mismo, les pedimos que lean las <a href="/docsInscripcion/Normas.pdf" target="_blank">normas del club</a>, para poder aceptarlas posteriormente.</p>
                    </div>
                </div>

                <input type="text" id="miembro_id" name="miembro_id" value="{{ (!is_null($miembro)) ? $miembro->id : '' }}" style="display:none">

                <div class="row card-panel">
                    <div>
                        <label>
                            <input type="checkbox" id="enviar" name="enviar" class="validate">
                            <span>Enviar el recibo de la preinscripción al correo indicado.</span>
                        </label>
                    </div>

{{--                     <div>
                        <label>
                            <input type="checkbox" id="imprimir" name="imprimir" class="validate">
                            <span>Imprimir el recibo de la preinscripción.</span>
                        </label>
                    </div>
 --}}                </div>

                <div class="col s12">
                    <button class="btn red" type="submit">Acepto las normas del club y realizo la Preinscripción</button>
                </div>

            </form>
        </div>
    </div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('select');
        var instances = M.FormSelect.init(elems);
}   );
</script>

@endsection

