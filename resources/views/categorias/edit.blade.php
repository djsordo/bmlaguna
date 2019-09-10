@extends('layouts.app')

{{-- @section('titulo', 'Editar categoría') --}}

@section('content')

@include('common.errors')

<div class="col s12 m12">
    <div class="section">
        <div class="row">
            <h4>Editar categoría</h4>
            <form action="/categorias/{{ $categoria->id }}" method="POST" class="col s12">
                @method('PUT')
                @csrf
                <div class="row card-panel z-depth-2">
                    <div class="input-field col s8">
                        <input type="text" placeholder="Descripción *" id="descripcion" name="descripcion" value="{{$categoria->descripcion}}" class="validate" required>
                        <label for="descripcion">Descripcion de la categoría:</label>
                    </div>
                    <div class="input-field col s4">
                        <input type="number" placeholder="Edad *" id="edad" name="edad" value="{{$categoria->edad}}" class="validate" required>
                        <label for="edad">Edad de comienzo de categoría:</label>
                    </div>
                    <div class="input-field col s6">
                        <input type="number" placeholder="Duración *" id="duracion" name="duracion" value="{{$categoria->duracion}}" class="validate" required>
                        <label for="duración">Duración de la categoría (años):</label>
                    </div>
                    <div class="input-field col s6">
                        <input type="number" placeholder="Precio *" id="precio_inscripcion" name="precio_inscripcion" value="{{$categoria->precio_inscripcion}}" class="validate" required>
                        <label for="precio_inscripcion">Precio de la inscripción:</label>
                    </div>    
                    <button class="btn red" type="submit">Guardar</button>
                </div>        
            </form>
        </div>
    </div>
</div>

</div>

@endsection