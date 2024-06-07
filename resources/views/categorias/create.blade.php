@extends('layouts.app')

{{-- @section('titulo', 'Crear categoría') --}}

@section('content')

@include('common.errors')

    <div class="col s12 m12">
        <div class="section">
            <div class="row">
                <h4>Crear categoría</h4>
                <form action="/categorias" method="POST" class="col s12">
                    @csrf
                    <div class="row card-panel z-depth-2">
                        <div class="input-field col s4">
                            <input type="text" placeholder="Descripción *" id="descripcion" name="descripcion" class="validate" required>
                            <label for="descripcion">Descripcion de la categoría:</label>
                        </div>
                        <div class="input-field col s4">
                            <input type="number" placeholder="Edad *" id="edad" name="edad" class="validate" required>
                            <label for="edad">Edad de comienzo de categoría:</label>
                        </div>
                        <div class="input-field col s4">
                            <input type="number" placeholder="Duración *" id="duracion" name="duracion" class="validate" required>
                            <label for="duración">Duración de la categoría (años):</label>
                        </div>
                        <div class="input-field col s4">
                            <input type="number" placeholder="Precio *" id="precio_inscripcion" name="precio_inscripcion" class="validate" required>
                            <label for="precio_inscripcion">Precio total de la inscripción (1 plazo):</label>
                        </div>
                        <div class="input-field col s4">
                            <input type="number" placeholder="Precio *" id="precio_inscripcion2c" name="precio_inscripcion2c" class="validate" required>
                            <label for="precio_inscripcion2c">Precio total de la inscripción (2 plazos):</label>
                        </div>
                        <div class="input-field col s4">
                            <input type="number" placeholder="Precio *" id="precio_inscripcion3c" name="precio_inscripcion3c" class="validate" required>
                            <label for="precio_inscripcion3c">Precio total de la inscripción (3 plazos):</label>
                        </div>
                        <div class="input-field col s4">
                        </div>
                        <div class="input-field col s4">
                            <input type="number" placeholder="Precio primera cuota *" id="precio_2c1" name="precio_2c1" class="validate" required>
                            <label for="precio_2c1">Precio de la primera cuota (2 plazos):</label>
                        </div>
                        <div class="input-field col s4">
                            <input type="number" placeholder="Precio primera cuota *" id="precio_3c1" name="precio_3c1" class="validate" required>
                            <label for="precio_3c1">Precio de la primera cuota (3 plazos):</label>
                        </div>
                        <div class="input-field col s4">
                        </div>
                        <div class="input-field col s4">
                            <input type="number" placeholder="Precio segunda cuota *" id="precio_2c2" name="precio_2c2" class="validate" required>
                            <label for="precio_2c2">Precio de la segunda cuota (2 plazos):</label>
                        </div>
                        <div class="input-field col s4">
                            <input type="number" placeholder="Precio segunda cuota *" id="precio_3c2" name="precio_3c2" class="validate" required>
                            <label for="precio_3c2">Precio de la segunda cuota (3 plazos):</label>
                        </div>
                        <div class="input-field col s4">
                        </div>
                        <div class="input-field col s4">
                        </div>
                        <div class="input-field col s4">
                            <input type="number" placeholder="Precio tercera cuota *" id="precio_3c3" name="precio_3c3" class="validate" required>
                            <label for="precio_3c3">Precio de la tercera cuota (3 plazos):</label>
                        </div>
                        <button class="btn red" type="submit">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
