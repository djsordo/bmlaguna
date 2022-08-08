@extends('layouts.app')

@section('content')

@include('common.errors')
<div class="row">
    <form method="POST" action="/reconocimientos"  class="col s12" enctype="multipart/form-data">
        @csrf
        
        <input type="text" id="miembro_id" name="miembro_id" value="{{$miembro->id}}" hidden>

        <div class="input-field col s6">
            <select name="temporada_id" id="tempSelect">
                @foreach ($temporadas as $temporada)
                    <option value="{{ $temporada->id }}">{{ $temporada->descripcion}}</option>
                @endforeach
            </select>
            <label for="tempSelect">Temporada</label>
        </div>  
        <div class="input-field col s6">
            <input type="date" id="f_reconocimiento" name="f_reconocimiento" placeholder="" value="{{ date('Y-m-d') }}">
            <label for="f_reconocimiento">Fecha de reconocimiento:</label>
        </div>


        <div class="input-field col s3">
            <input type="number" placeholder="000,000" id="peso" name="peso" class="validate" step="0.001" required>
            <label for="peso">Peso:</label>
        </div>

        <div class="input-field col s3">
            <input type="number" placeholder="000" id="talla" name="talla" class="validate" required>
            <label for="talla">Talla:</label>
        </div>

        <div class="input-field col s3">
            <input type="number" placeholder="000" id="tensionH" name="tensionH" class="validate" required>
            <label for="tensionH">Tensión (alta):</label>
        </div>

        <div class="input-field col s3">
            <input type="number" placeholder="000" id="tensionL" name="tensionL" class="validate" required>
            <label for="tensionL">Tensión (baja):</label>
        </div>
        <div class="input-field col s3">
            <input type="number" placeholder="00" id="saturacion" name="saturacion" class="validate" required>
            <label for="saturacion">Saturación:</label>
        </div>
        <div class="input-field col s3">
            <input type="number" placeholder="00" id="FC" name="FC" class="validate" required>
            <label for="FC">FC:</label>
        </div>
        <div class="input-field col s3">
            <input type="number" placeholder="00" id="FCPEST" name="FCPEST" class="validate" required>
            <label for="FCPEST">FC-PEST:</label>
        </div>
        <div class="input-field col s3">
            <input type="text" placeholder="Medicación" id="medicacion" name="medicacion" class="validate" value="NO">
            <label for="obserMedicas">Medicación:</label>
        </div>
        <div class="input-field col s3">
            <input type="text" placeholder="Oido" id="oido" name="oido" class="validate" value="NORMAL" required>
            <label for="oido">Oido:</label>
        </div>
        <div class="input-field col s3">
            <input type="text" placeholder="Vista" id="vista" name="vista" class="validate" value="NORMAL" required>
            <label for="vista">Vista:</label>
        </div>
        <div class="input-field col s3">
            <input type="text" placeholder="Columna" id="columna" name="columna" class="validate" value="NORMAL" required>
            <label for="columna">Columna:</label>
        </div>
        <div class="input-field col s3">
            <input type="text" placeholder="ACA" id="ACA" name="ACA" class="validate" value="NORMAL" required>
            <label for="ACA">ACA:</label>
        </div>

        <div class="col s12">
            <button class="btn red" type="submit">Guardar</button>
        </div>

    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('select');
        var instances = M.FormSelect.init(elems);
    });
</script>

@endsection