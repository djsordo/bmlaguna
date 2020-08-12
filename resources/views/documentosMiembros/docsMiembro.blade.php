@extends('layouts.app')

@section('content')

@include('common.success')

<div class="row">
    <p class="flow-text center">Documentación de {{$miembro->nombre . ' ' . $miembro->apellido1 . ' ' . $miembro->apellido2}}</p>
    <a class="btn-floating btn-large waves-effect waves-light red modal-trigger" href="#addDoc"><i class="material-icons">add</i></a>
    
    <!-- Modal Structure -->
    <div id="addDoc" class="modal">
        <div class="modal-content">
            <h4>Nuevo Documento</h4>
            <div class="row">
                <form method="POST" action="/documentosMiembros"  class="col s12" enctype="multipart/form-data">
                    @csrf
                    <div class="col s6">
                        <img class="materialboxed" width="150px" src="/images/sinfoto.jpg" id="docImagen" alt="">                                  
                    </div>

                    <div class="input-field">
                        <input type="text" name="miembro_id" value="{{$miembro->id}}" hidden>
                    </div>
                    <div class="input-field col s6">
                        <input type="date" id="f_entrega" name="f_entrega" placeholder="" value="{{date('Y-m-d')}}">
                        <label for="f_entrega">Fecha de entrega:</label>
                    </div>

                    <div class="input-field col s8">
                        <select id="documento_id" name="documento_id" placeholder="Documento">
                            <option value="" selected>-- Elige un tipo de documento --</option>
                            @foreach ($documentos as $documento)
                                <option value="{{ $documento->id }}">{{ $documento->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="input-field col s4">
                        <input type="date" id="f_caducidad" name="f_caducidad" placeholder="">
                        <label for="f_nacimiento">Fecha de caducidad:</label>
                    </div>

                    {{-- <div class="input-field col s5">
                        <input type="text" class="datepicker" name="f_caducidad">
                        <label for="f_caducidad">Fecha de caducidad</label>
                    </div> --}}
                    
                    <div class="file-field input-field col s12">
                        <div class="btn red">
                            <span>Documento</span>
                            <input type="file" name="ruta" id="rutaDoc">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" name="ruta">
                        </div>
                    </div>
                    <div class="modal-footer col s12">
                        <button class="modal-close waves-effect waves-green btn" type="submit">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($miembro->fotos as $foto)
        <div class="card row">
            <div class="col s2">
                <img class="materialboxed" width="100px" src="{{'/docs/'.$foto->pivot->ruta}}">
            </div>

            <div class="col s8">
                <p class="flow-text">{{$foto->descripcion}}</p>
                <p>Fecha de Entrega: {{date('d-m-Y', strtotime($foto->pivot->f_entrega))}}</p>
                @if ($miembro->fotos->find(1)->pivot->f_entrega == $foto->pivot->f_entrega)
                    <p>ACTUAL</p>
                @endif
            </div>

            <div class="col s2">
                <form action="/documentosMiembros/{{$miembro->id}}-{{$foto->pivot->id}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-floating black right"><i class="material-icons">delete</i></button>   
                </form>
            </div>
        </div>
    @endforeach

    @foreach ($miembro->documentos as $documento)
        @if ($documento->descripcion != 'foto')
            <div class="card row valign-wrapper">
                <div class="col s2">
                    @if (ends_with($documento->pivot->ruta, '.pdf') == False)
                        <img class="materialboxed" width="100px" src="{{'/docs/'.$documento->pivot->ruta}}">
                    @else
                        <a target="_blank" href="{{'/docs/'.$documento->pivot->ruta}}"><img width="100px" src="/images/pdf.png"></a>
                    @endif
                </div>

                <div class="col s6">
                    <p class="flow-text">{{$documento->descripcion}}</p>
                    <p>Fecha de Entrega: {{date('d-m-Y', strtotime($documento->pivot->f_entrega))}}</br>
                        @if (isset($documento->pivot->f_caducidad)) 
                            Fecha de Caducidad: {{date('d-m-Y', strtotime($documento->pivot->f_caducidad))}}
                        @endif
                    </p>
                    @if (isset($documento->pivot->f_caducidad)) 
                        @if ($documento->pivot->f_caducidad >= date('Y-m-d'))
                            <p>ACTIVO</p>
                        @else
                            <p>CADUCADO</p>
                        @endif
                    @endif
                </div>
                    
                <div class="col s2">
                    
                </div>

                <div class="col s2">
                    <form action="/documentosMiembros/{{$miembro->id}}-{{$documento->pivot->id}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-floating black right"><i class="material-icons">delete</i></button>   
                    </form>
                </div>
            </div>
        @endif
    @endforeach
</div>

<script>
    $(document).ready(function(){
	    $('#documento_id').sm_select();
    })

    // document.addEventListener('DOMContentLoaded', function() {
    //     var elems = document.querySelectorAll('select');
    //     var instances = M.FormSelect.init(elems);
    // });


  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.carousel');
    var instances = M.Carousel.init(elems, {indicators : true } );
  });

  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.materialboxed');
    var instances = M.Materialbox.init(elems);
  });

  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.modal');
    var instances = M.Modal.init(elems);
  });

//   document.addEventListener('DOMContentLoaded', function() {
//         var elems = document.querySelectorAll('.datepicker');
//         var instances = M.Datepicker.init(elems, {
//             firstDay: 1,
//             showClearBtn: true,
//             showMonthAfterYear: true,
//             //autoClose: true,
//             format: 'dd-mm-yyyy',
//             yearRange: 50,
//             i18n: {
//                 months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
//                 monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
//                 weekdays: ["Domingo","Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
//                 weekdaysShort: ["Dom","Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
//                 weekdaysAbbrev: ["D","L", "M", "M", "J", "V", "S"]
//             }
//         });
//     });

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

  document.getElementById('rutaDoc').addEventListener('change', archivoFoto, false);

</script>

@endsection
