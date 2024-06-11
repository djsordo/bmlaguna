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
                        <div class="input-field col s2">
                            <input type="number" placeholder="Precio *" id="precio_inscripcion" name="precio_inscripcion" class="validate" required>
                            <label for="precio_inscripcion">Inscripción (1 plazo):</label>
                        </div>
                        <div class="input-field col s2">
                            <input type="date" id="f_plazo_insc" name="f_plazo_insc" placeholder="" value="">
                            <label for="f_plazo_insc">Fecha Plazo:</label>
                        </div>

                        <div class="input-field col s4">
                            <input type="number" placeholder="Precio *" id="precio_inscripcion2c" name="precio_inscripcion2c" class="validate" required>
                            <label for="precio_inscripcion2c">Inscripción (2 plazos):</label>
                        </div>
                        <div class="input-field col s4">
                            <input type="number" placeholder="Precio *" id="precio_inscripcion3c" name="precio_inscripcion3c" class="validate" required>
                            <label for="precio_inscripcion3c">Inscripción (3 plazos):</label>
                        </div>
                        <div class="input-field col s4">
                        </div>

                        <div class="input-field col s2">
                            <input type="number" placeholder="Precio *" id="precio_2c1" name="precio_2c1" class="validate" required>
                            <label for="precio_2c1">1ª cuota (2 plazos):</label>
                        </div>
                        <div class="input-field col s2">
                            <input type="date" id="f_plazo_2c1" name="f_plazo_2c1" placeholder="" value="">
                            <label for="f_plazo_2c1">Fecha Plazo:</label>
                        </div>

                        <div class="input-field col s2">
                            <input type="number" placeholder="Precio *" id="precio_3c1" name="precio_3c1" class="validate" required>
                            <label for="precio_3c1">1ª cuota (3 plazos):</label>
                        </div>
                        <div class="input-field col s2">
                            <input type="date" id="f_plazo_3c1" name="f_plazo_3c1" placeholder="" value="">
                            <label for="f_plazo_3c1">Fecha Plazo:</label>
                        </div>

                        <div class="input-field col s4">
                        </div>

                        <div class="input-field col s2">
                            <input type="number" placeholder="Precio *" id="precio_2c2" name="precio_2c2" class="validate" required>
                            <label for="precio_2c2">2ª cuota (2 plazos):</label>
                        </div>
                        <div class="input-field col s2">
                            <input type="date" id="f_plazo_2c2" name="f_plazo_2c2" placeholder="" value="">
                            <label for="f_plazo_2c2">Fecha Plazo:</label>
                        </div>

                        <div class="input-field col s2">
                            <input type="number" placeholder="Precio *" id="precio_3c2" name="precio_3c2" class="validate" required>
                            <label for="precio_3c2">2ª cuota (3 plazos):</label>
                        </div>
                        <div class="input-field col s2">
                            <input type="date" id="f_plazo_3c2" name="f_plazo_3c2" placeholder="" value="">
                            <label for="f_plazo_3c2">Fecha Plazo:</label>
                        </div>

                        <div class="input-field col s4">
                        </div>
                        <div class="input-field col s4">
                        </div>

                        <div class="input-field col s2">
                            <input type="number" placeholder="Precio *" id="precio_3c3" name="precio_3c3" class="validate" required>
                            <label for="precio_3c3">3ª cuota (3 plazos):</label>
                        </div>
                        <div class="input-field col s2">
                            <input type="date" id="f_plazo_3c3" name="f_plazo_3c3" placeholder="" value="">
                            <label for="f_plazo_3c3">Fecha Plazo:</label>
                        </div>

                        <button class="btn red" type="submit">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
