<div class="row card-panel">
    <div class="section row">
        <span class="card-title col s8"><strong class="flow-text">Datos Personales</strong></span>
        <div class="col s4">
            @if (!is_null($miembro))
                @if (is_null($miembro->rutaFoto()))
                    <img class="materialboxed" width="150px" src="/images/sinfoto.jpg" id="foto" alt="">                                  
                @else
                    <img class="materialboxed" width="150px" src="{{'/docs/'.$miembro->rutaFoto()}}" id="foto" alt="">                                                
                @endif
            @endif
        </div>
    </div>

    <div class="input-field col s4">
        <input type="text" id="nif" name="nif" class="validate" value="{{ (!is_null($miembro)) ? $miembro->nif : '' }}" pattern="(([X-Z]{1})([-]?)(\d{7})([-]?)([A-Z]{1}))|((\d{8})([-]?)([A-Z]{1}))">
        <label for="nif">N.I.F. :</label>
    </div>

    <div class="input-field col s4">
        <input type="date" id="f_nacimiento" name="f_nacimiento" placeholder="" value="{{ (!is_null($miembro)) ? $miembro->f_nacimiento : '' }}">
        <label for="f_nacimiento">Fecha de nacimiento:</label>
    </div>

    {{-- <div class="input-field col s4">
        <input type="text" class="datepicker validate" id="f_nacimiento" name="f_nacimiento" value="{{ (!is_null($miembro)) ? $miembro->f_nacimiento : '' }}">
        <label for="f_nacimiento">Fecha de nacimiento:</label>
    </div> --}}

    <div class="input-field col s4">
        <label style = "position: absolute; top: -26px; font-size: 0.8rem">Género</label>
        <select id="genero_id" name="genero_id" placeholder="Género">
            <option value="" selected>-- Elige un género --</option>
            @foreach ($generos as $genero)
                <option value="{{ $genero->id }}" @if (!is_null($miembro)) {{ ($genero->id == $miembro->genero_id) ? 'selected' : '' }} @endif >{{ $genero->descripcion }}</option>
            @endforeach
        </select>
        
    </div>

    <div class="input-field col s4">
        <input type="text"id="nombre" name="nombre" class="validate" value="{{ (!is_null($miembro)) ? $miembro->nombre : '' }}" required>
        <label for="nombre">Nombre:</label>
    </div>

    <div class="input-field col s4">
        <input type="text"id="apellido1" name="apellido1" class="validate" value="{{ (!is_null($miembro)) ? $miembro->apellido1 : '' }}" required>
        <label for="apellido1">Primer apellido:</label>
    </div>
    <div class="input-field col s4">
        <input type="text"id="apellido2" name="apellido2" value="{{ (!is_null($miembro)) ? $miembro->apellido2 : '' }}" class="validate">
        <label for="apellido2">Segundo apellido:</label>
    </div>
    <div class="input-field col s8">
        <input type="text"id="centroEducativo" name="centroEducativo" value="{{ (!is_null($miembro)) ? $miembro->centroEducativo : '' }}">
        <label for="centroEducativo">Centro Educativo:</label>
    </div>

    <div class="input-field col s2">
        <input type="text"id="nSocio" name="nSocio" value="{{ (!is_null($miembro)) ? $miembro->nSocio : '' }}">
        <label for="centroEducativo">Número de Socio:</label>
    </div>

    <div class="input-field col s2">
        <label style = "position: absolute; top: -26px; font-size: 0.8rem">Dorsal</label>
        <select id="dorsal" name="dorsal" placeholder="Dorsal">
            <option value="" selected>-- Elige un dorsal --</option>
            @foreach ($dorsales as $dorsal)
                <option value="{{ $dorsal }}" @if (!is_null($miembro)) {{ ($dorsal == $miembro->dorsal) ? 'selected' : '' }} @endif >{{ $dorsal }}</option>
            @endforeach
        </select>
        
    </div>
    
    <div class="input-field col s6">
        <textarea id="observaciones" name="observaciones" value="{{ (!is_null($miembro)) ? $miembro->observaciones : '' }}" class="materialize-textarea"></textarea>
        <label for="observaciones">Observaciones</label>
    </div>

    <div class="input-field col s6">
        <textarea id="obserMedicas" name="obserMedicas" value="{{ (!is_null($miembro)) ? $miembro->obserMedicas : '' }}" class="materialize-textarea"></textarea>
        <label for="observaciones">Observaciones Médicas</label>
    </div>

    {{-- <div class="input-field col s3 right">
        <input type="text" class="datepicker validate" id="f_baja" name="f_baja" value="{{ (!is_null($miembro)) ? $miembro->f_baja : '' }}">
        <label for="f_baja">Fecha de baja en el club:</label>
    </div> --}}

    <div class="input-field col s3 right">
        <input type="date" id="f_baja" name="f_baja" placeholder="" value="{{ (!is_null($miembro)) ? $miembro->f_baja : '' }}">
        <label for="f_baja">Fecha de baja en el club:</label>
    </div>


</div>

<script>
    $(document).ready(function(){
	    $('#genero_id').sm_select();
	    $('#dorsal').sm_select();
    })


    function archivoFoto(evt) {
        var files = evt.target.files; // FileList object
       
        //Obtenemos la imagen del campo "file". 
        for (var i = 0, f; f = files[i]; i++) {         
            //Solo admitimos imágenes.
            if (!f.type.match('image.*')) {
                continue;
            }
       
            var reader = new FileReader();
           
            reader.onload = (function(theFile) {
                return function(e) {
                    document.getElementById('foto').src = e.target.result;
                };
            })(f);
 
           reader.readAsDataURL(f);
       }
    }
    document.getElementById('ruta').addEventListener('change', archivoFoto, false);

    function archivoDNIF(evt) {
        var files = evt.target.files; // FileList object
       
        //Obtenemos la imagen del campo "file". 
        for (var i = 0, f; f = files[i]; i++) {         
            //Solo admitimos imágenes.
            if (!f.type.match('image.*')) {
                continue;
            }
       
            var reader = new FileReader();
           
            reader.onload = (function(theFile) {
                return function(e) {
                    document.getElementById('fotoDNIF').src = e.target.result;
                };
            })(f);
 
           reader.readAsDataURL(f);
       }
    }
    document.getElementById('rutaDNIF').addEventListener('change', archivoDNIF, false);

    function archivoDNIP(evt) {
        var files = evt.target.files; // FileList object
       
        //Obtenemos la imagen del campo "file". 
        for (var i = 0, f; f = files[i]; i++) {         
            //Solo admitimos imágenes.
            if (!f.type.match('image.*')) {
                continue;
            }
       
            var reader = new FileReader();
           
            reader.onload = (function(theFile) {
                return function(e) {
                    document.getElementById('fotoDNIP').src = e.target.result;
                };
            })(f);
 
           reader.readAsDataURL(f);
       }
    }
    document.getElementById('rutaDNIP').addEventListener('change', archivoDNIP, false);

    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.datepicker');
        var instances = M.Datepicker.init(elems, {
            firstDay: 1,
            showClearBtn: true,
            showMonthAfterYear: true,
            //autoClose: true,
            format: 'dd-mm-yyyy',
            yearRange: 50,
            i18n: {
                months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
                weekdays: ["Domingo","Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                weekdaysShort: ["Dom","Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
                weekdaysAbbrev: ["D","L", "M", "M", "J", "V", "S"]
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.materialboxed');
        var instances = M.Materialbox.init(elems);
    });

    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('select');
        var instances = M.FormSelect.init(elems);
    });

</script>