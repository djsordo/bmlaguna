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
                        <div class="input-field col s8">
                            <input type="text"id="centroEducativo" name="centroEducativo" class="validate" required value="{{ (!is_null($miembro)) ? $miembro->centroEducativo : '' }}">
                            <label for="centroEducativo">Centro Educativo: *</label>
                        </div>
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
                            <input type="email" id="email" name="email" class="validate" required value="{{ (!is_null($email)) ? $email->email : '' }}">
                            <label for="email">Correo Electrónico: *</label>
                        </div>
                    </div>
                </div>

                <div>
                    <label>
                        <input type="checkbox" id="socio" name="socio" class="validate">
                        <span>Pulsa aquí si quieres ser socio del Balonmano Laguna. Ser socio implica poder acceder a las asambleas del club, además de otras ventajas.</span>
                    </label>
                </div>

                <div class="row card-panel">
                    <div class="col s12">
                        <span class="flow-text">IMPORTE DE LA PREINSCRIPCIÓN: 100€ A DESCONTAR DE LA CUOTA ANUAL</span>
                    </div>

                    <div class="col s12">
                        <p align="justify">AVISO DE CONFIDENCIALIDAD: según lo dispuesto en la legislación en materia de protección de datos y por el RGPD UE 2016/679 de la LSSI (34/2002), garantizamos la confidencialidad de sus datos los cuales serán incluidos en un fichero de nuestra propiedad. Usted podrá ejercitar sus derechos de acceso, rectificación, cancelación o supresión, oposición, limitación del tratamiento o portabilidad de sus datos comunicándose por correo electrónico a <b>bmlagunadircc@gmail.com</b>. Igualmente tiene usted derecho a presentar una reclamación ante la Agencia de Protección de Datos.</p>
                        <p align="justify">La aceptación como miembro del Club Balonmnao Laguna esta supeditada a la firma del documento de normas del club, aprobado por Asamblea en junio del 2018. Este documento le será facilitado para su firma una vez cumplido el proceso de inscripción.
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
                    <button class="btn red" type="submit">Validar y Pagar Preinscripción</button>
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

