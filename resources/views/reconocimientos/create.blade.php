@extends('layouts.app')

@section('content')

@include('common.errors')
<div class="row">
    <form method="POST" action="/reconocimientos"  class="col s12" enctype="multipart/form-data">
        @csrf

        <div class="input-field col s4">
            <input type="date" id="f_reconocimiento" name="f_reconocimiento" placeholder="" value="{{ date('Y-m-d') }}">
            <label for="f_reconocimiento">Fecha de reconocimiento:</label>
        </div>

        <div class="input-field col s3">
            <input type="number" placeholder="000,0" id="peso" name="peso" class="validate" required>
            <label for="peso">Peso:</label>
        </div>

        <div class="input-field col s3">
            <input type="number" placeholder="0,00" id="talla" name="talla" class="validate" required>
            <label for="talla">Talla:</label>
        </div>

        <div class="input-field col s3">
            <input type="number" placeholder="00,00" id="tensionH" name="tensionH" class="validate" required>
            <label for="tensionH">Tensión (alta):</label>
        </div>

        <div class="input-field col s3">
            <input type="number" placeholder="00,00" id="tensionL" name="tensionL" class="validate" required>
            <label for="tensionL">Tensión (baja):</label>
        </div>
        <div class="input-field col s3">
            <input type="number" placeholder="000,00" id="saturacion" name="saturacion" class="validate" required>
            <label for="saturacion">Saturación:</label>
        </div>
        <div class="input-field col s3">
            <input type="number" placeholder="000,00" id="FC" name="FC" class="validate" required>
            <label for="FC">FC:</label>
        </div>
        <div class="input-field col s3">
            <input type="number" placeholder="000,00" id="FC-PEST" name="FC-PEST" class="validate" required>
            <label for="FC-PEST">FC-PEST:</label>
        </div>
        <div class="input-field col s3">
            <input type="text" placeholder="Medicación" id="obserMedicas" name="obserMedicas" class="validate">
            <label for="obserMedicas">Medicación:</label>
        </div>
        <div class="input-field col s3">
            <input type="text" placeholder="Oido" id="oido" name="oido" class="validate" required>
            <label for="oido">Oido:</label>
        </div>
        <div class="input-field col s3">
            <input type="text" placeholder="Vista" id="vista" name="vista" class="validate" required>
            <label for="vista">Vista:</label>
        </div>
        <div class="input-field col s3">
            <input type="text" placeholder="Columna" id="columna" name="columna" class="validate" required>
            <label for="columna">Columna:</label>
        </div>
        <div class="input-field col s3">
            <input type="text" placeholder="ACA" id="ACA" name="ACA" class="validate" required>
            <label for="ACA">ACA:</label>
        </div>
    </form>
</div>
@endsection