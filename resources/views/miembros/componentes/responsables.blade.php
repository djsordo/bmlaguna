<div class="row card-panel">
    <div class="row section">
        <span class="card-title col s12"><strong class="flow-text">Familiares</strong></span>
    </div>

    <div class="row">
        <div class="valign-wrapper">
            <div class="input-field col s10">
                <select id="responsable1_id" name="responsable1_id">
                    <option value="" selected>-- Elige un responsable --</option>
                    @foreach ($responsables as $responsable)
                        <option value="{{ $responsable->id }}" @if (!is_null($miembro)) {{ ($responsable->id == $miembro->responsable1_id) ? 'selected' : '' }} @endif >{{ $responsable->nombre . ' ' . $responsable->apellido1 . ' ' . $responsable->apellido2 }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col s2" >
                <a class="btn red right" id="muestraR1"><i class="material-icons">arrow_drop_down</i></a>
            </div>
        </div>

        <div class="col s12" id="cuerpoR1">
            <div class="input-field col s2">
                <input type="text"id="nombreR1" name="r1[nombre]" class="validate">
                <label for="nombreR1">Nombre:</label>
            </div>
            <div class="input-field col s5">
                <input type="text"id="apellido1R1" name="r1[apellido1]" class="validate">
                <label for="apellido1R1">Primer apellido:</label>
            </div>
            <div class="input-field col s5">
                <input type="text"id="apellido2R1" name="r1[apellido2]" class="validate">
                <label for="apellido2R1">Segundo apellido:</label>
            </div>

            <div class="input-field col s12">
                <input type="text" id="domicilioR1" name="r1[domicilio]" class="validate">
                <label for="domicilioR1">Domicilio:</label>
            </div>
            <div class="input-field col s5">
                <input type="text"id="localidadR1" name="r1[localidad]" class="validate">
                <label for="localidadR1">Localidad:</label>
            </div>
            <div class="input-field col s5">
                <input type="text"id="provinciaR1" name="r1[provincia]" class="validate">
                <label for="provinciaR1">Provincia:</label>
            </div>
            <div class="input-field col s2">
                <input type="text"id="c_postalR1" name="r1[c_postal]" class="validate">
                <label for="c_postalR1">Código Postal:</label>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="valign-wrapper">
            <div class="input-field col s10">
                <select name="responsable2_id" id="responsable2_id">
                    <option value="" selected>-- Elige un responsable --</option>
                    @foreach ($responsables as $responsable)
                        <option value="{{ $responsable->id }}" @if (!is_null($miembro)) {{ ($responsable->id == $miembro->responsable2_id) ? 'selected' : '' }} @endif >{{ $responsable->nombre . ' ' . $responsable->apellido1 . ' ' . $responsable->apellido2 }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col s2" >
                <a class="btn red right" id="muestraR2"><i class="material-icons">arrow_drop_down</i></a>
            </div>
        </div>
        <div class="col s12" id="cuerpoR2">
            <div class="input-field col s2">
                <input type="text"id="nombreR2" name="r2[nombre]" class="validate">
                <label for="nombreR2">Nombre:</label>
            </div>
            <div class="input-field col s5">
                <input type="text"id="apellido1R2" name="r2[apellido1]" class="validate">
                <label for="apellido1R2">Primer apellido:</label>
            </div>
            <div class="input-field col s5">
                <input type="text"id="apellido2R2" name="r2[apellido2]" class="validate">
                <label for="apellido2R2">Segundo apellido:</label>
            </div>

            <div class="input-field col s12">
                <input type="text" id="domicilioR2" name="r2[domicilio]" class="validate">
                <label for="domicilioR2">Domicilio:</label>
            </div>
            <div class="input-field col s5">
                <input type="text"id="localidadR2" name="r2[localidad]" class="validate">
                <label for="localidadR2">Localidad:</label>
            </div>
            <div class="input-field col s5">
                <input type="text"id="provinciaR2" name="r2[provincia]" class="validate">
                <label for="provinciaR2">Provincia:</label>
            </div>
            <div class="input-field col s2">
                <input type="text"id="c_postalR2" name="r2[c_postal]" class="validate">
                <label for="c_postalR2">Código Postal:</label>
            </div>
        </div>
    </div>
</div>

<script>

    // document.addEventListener('DOMContentLoaded', function() {
    //     var elems = document.querySelectorAll('select');
    //     var instances = M.FormSelect.init(elems);
    // });

    $(document).ready(function(){
	    $('#responsable1_id').sm_select();
	    $('#responsable2_id').sm_select();
    })

    document.getElementById('cuerpoR1').style.display = 'none';
    document.getElementById('cuerpoR2').style.display = 'none';

    if (document.getElementById('responsable1_id').value == ""){
        document.getElementById('muestraR1').classList.remove("disabled");
        }
    else{
        document.getElementById('muestraR1').classList.add("disabled");
    }

    if (document.getElementById('responsable2_id').value == ""){
        document.getElementById('muestraR2').classList.remove("disabled");
        }
    else{
        document.getElementById('muestraR2').classList.add("disabled");
    }

        // Botón para desplegar datos y requerir campos del Responsable 1.
        document.getElementById('muestraR1').onclick = function(){
        el = document.getElementById('cuerpoR1');
        if (el.style.display == 'none'){
            el.style.display =  'block';
            el.childNodes[1].childNodes[1].required =true;
            el.childNodes[3].childNodes[1].required =true;
            //el.childNodes[7].childNodes[1].required =true;
            //el.childNodes[9].childNodes[1].required =true;
            //el.childNodes[11].childNodes[1].required =true;
            //el.childNodes[13].childNodes[1].required =true;

            el.childNodes[7].childNodes[1].value = document.getElementById('domicilio').value;
            el.childNodes[9].childNodes[1].value = document.getElementById('localidad').value;
            el.childNodes[11].childNodes[1].value = document.getElementById('provincia').value;
            el.childNodes[13].childNodes[1].value = document.getElementById('c_postal').value;
        }
        else{
            el.style.display =  'none';
            el.childNodes[1].childNodes[1].required =false;
            el.childNodes[3].childNodes[1].required =false;
            //el.childNodes[7].childNodes[1].required =false;
            //el.childNodes[9].childNodes[1].required =false;
            //el.childNodes[11].childNodes[1].required =false;
            //el.childNodes[13].childNodes[1].required =false;

            el.childNodes[7].childNodes[1].value = document.getElementById('domicilio').value;
            el.childNodes[9].childNodes[1].value = document.getElementById('localidad').value;
            el.childNodes[11].childNodes[1].value = document.getElementById('provincia').value;
            el.childNodes[13].childNodes[1].value = document.getElementById('c_postal').value;
        }
               
        M.updateTextFields();
    }

    // Botón para desplegar campos y requerir campos Responsable 2.
    document.getElementById('muestraR2').onclick = function(){
        el = document.getElementById('cuerpoR2');
        if (el.style.display == 'none'){
            el.style.display =  'block';
            el.childNodes[1].childNodes[1].required =true;
            el.childNodes[3].childNodes[1].required =true;
            //el.childNodes[7].childNodes[1].required =true;
            //el.childNodes[9].childNodes[1].required =true;
            //el.childNodes[11].childNodes[1].required =true;
            //el.childNodes[13].childNodes[1].required =true;

            el.childNodes[7].childNodes[1].value = document.getElementById('domicilio').value;
            el.childNodes[9].childNodes[1].value = document.getElementById('localidad').value;
            el.childNodes[11].childNodes[1].value = document.getElementById('provincia').value;
            el.childNodes[13].childNodes[1].value = document.getElementById('c_postal').value;
        }
        else{
            el.style.display =  'none';
            el.childNodes[1].childNodes[1].required =false;
            el.childNodes[3].childNodes[1].required =false;
            //el.childNodes[7].childNodes[1].required =false;
            //el.childNodes[9].childNodes[1].required =false;
            //el.childNodes[11].childNodes[1].required =false;
            //el.childNodes[13].childNodes[1].required =false;

            el.childNodes[7].childNodes[1].value = document.getElementById('domicilio').value;
            el.childNodes[9].childNodes[1].value = document.getElementById('localidad').value;
            el.childNodes[11].childNodes[1].value = document.getElementById('provincia').value;
            el.childNodes[13].childNodes[1].value = document.getElementById('c_postal').value;
        }
        M.updateTextFields();
    }

    // Mostrar u ocultar cuando cambia la el select de responsable1
    document.getElementById('responsable1_id').onchange = function(){
        console.log('cambia select');
        var boton = document.getElementById('muestraR1');
        var sel = document.getElementById('responsable1_id');
        var el = document.getElementById('cuerpoR1');

        if (sel.value == ""){
            boton.classList.remove("disabled");
        }
        else{
            boton.classList.add("disabled");
            el.style.display = 'none';
        }
    }
    // Mostrar u ocultar cuando cambia la el select de responsable2
    document.getElementById('responsable2_id').onchange = function(){
        console.log('cambia select');
        var boton = document.getElementById('muestraR2');
        var sel = document.getElementById('responsable2_id');
        var el = document.getElementById('cuerpoR2');

        if (sel.value == ""){
            boton.classList.remove("disabled");
        }
        else{
            boton.classList.add("disabled");
            el.style.display = 'none';
        }
    }

</script>
