@extends('layouts.app')

@section('content')

@include('common.success')

<div class="col s12 m8">
    <div class="section row">

        <div class="col s7 center">
            <h4>Mantenimiento de equipaciones</h4>
        </div>
        <div class="col s2 center">
                <a href="{{ route('equipaciones.create') }}" class="btn-floating red waves-effect right"><i class="material-icons">add</i></a> 
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



        <div class="col s12 center">
            <table>
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Marca</th>
                        <th>Imagen</th>
                        <th>Tallas</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($equipaciones as $equipacion)
                        <tr>
                            <td>{{$equipacion->descripcion}}</td>
                            <td>{{$equipacion->marca}}</td>
                            <td>
                                @if (is_null($equipacion->rutaImagen))
                                    <img class="materialboxed" width="40px" src="/images/sinfoto.jpg" id="foto" alt="">                                  
                                @else
                                    <img class="materialboxed" width="40px" src="{{'/images/'.$equipacion->rutaImagen}}" id="foto" alt="">
                                @endif
                            </td>
                            <td>
                                @foreach ($equipacion->tallas as $talla)
                                    {{$talla->descripcion.' '}}
                                @endforeach
                            </td>
                            <td>
                                <a href="/equipaciones/{{$equipacion->id}}/edit" class="secondary-content"><i class="material-icons green-text">edit</i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

<script>

    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('select');
        var instances = M.FormSelect.init(elems);
    });

    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.materialboxed');
        var instances = M.Materialbox.init(elems);
    });

    $select = document.getElementById("tempSelect").onchange = function(){
        document.getElementById("tempForm").submit();
    };


</script>
@endsection