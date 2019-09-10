<div class="row card-panel z-depth-2">
    <div class="col s3">
        @if (is_null($equipacione))
            <img class="materialboxed" width="100px" src="/images/sinfoto.jpg" id="docImagen" alt="">
        @else
            <img class="materialboxed" width="100px" src="{{(!is_null($equipacione->rutaImagen)) ? '/images/'.$equipacione->rutaImagen : ''}}" id="docImagen" alt="">
        @endif
    </div>

    <div class="file-field input-field col s4">
        <div class="btn red">
            <span>Imagen</span>
            <input type="file" name="rutaImagen" id="rutaImg" >
        </div>
        <div class="file-path-wrapper">
            <input class="file-path validate" type="text" name="rutaImagen"
                @if (!is_null($equipacione) && !is_null($equipacione->rutaImagen))
                    value="{{ $equipacione->rutaImagen }}"
                @endif
            >
        </div>
    </div>        

    <div class="input-field col s2 right"> 
        <label style = "position: absolute; top: -26px; font-size: 0.8rem">Temporada:</label>
        <select name="temporada_id" id="temporada">
            {{-- <option value="" disabled selected>Elige una</option> --}}
            @foreach ($temporadas as $temporada)
                @if (is_null($equipacione))
                    <option value="{{ $temporada->id }}" {{ ($temporada->id == $tempActual->id) ? 'selected' : ''}}>{{ $temporada->descripcion}}</option>
                @else
                    <option value="{{ $temporada->id }}" {{ ($temporada->id == $equipacione->temporada_id) ? 'selected' : ''}}>{{ $temporada->descripcion}}</option>
                @endif
            @endforeach
        </select>
        
    </div>

    <div class="input-field col s5">
        <input type="text" id="descripcion" name="descripcion" class="validate" value="{{(!is_null($equipacione)) ? $equipacione->descripcion : ' ' }}" required>
        <label for="descripcion">Descripcion de la equipación:</label>
    </div>
    <div class="input-field col s4">
            <input type="text" id="marca" name="marca" class="validate" value="{{(!is_null($equipacione)) ? $equipacione->marca : ' '}}" required>
            <label for="marca">Marca:</label>
    </div>

    <div class="input-field col s10">
        <label style = "position: absolute; top: -26px; font-size: 0.8rem">Tallas disponibles</label>
        <select name="tallas_id[]" id="tallas" multiple>
            {{-- <option value="" disabled selected>Elige las tallas</option> --}}
            @foreach ($tallas as $talla)
                <option value="{{$talla->id}}" 
                    @if (!is_null($tallasElegidas))
                        @foreach ($tallasElegidas as $tallaElegida)
                            @if ($tallaElegida->id == $talla->id)
                                selected
                            @endif
                        @endforeach
                    @endif
                >{{$talla->descripcion}}</option>
            @endforeach
        </select>
        
    </div>

    <div class="col s12">
        <button class="btn red  right" type="submit">Guardar</button>
    </div>
</div>

<script>
    $(document).ready(function(){
	    $('#temporada').sm_select();
        $('#tallas').sm_select();
    })

    // document.addEventListener('DOMContentLoaded', function() {
    //     var elems = document.querySelectorAll('select');
    //     var instances = M.FormSelect.init(elems);
    // });

    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.materialboxed');
        var instances = M.Materialbox.init(elems);
    });

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
                    document.getElementById('docImagen').src = e.target.result;
                };
            })(f);
 
           reader.readAsDataURL(f);
       }
    }

  document.getElementById('rutaImg').addEventListener('change', archivoFoto, false);

</script>