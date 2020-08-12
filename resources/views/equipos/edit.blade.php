@extends('layouts.app')

{{-- @section('titulo', 'Crear Equipo') --}}

@section('content')

@include('common.errors')


        <div class="section">
            <div class="row">
                <h4>Editar equipo</h4>
                <form method="POST" action="/equipos/{{ $equipo->id }}" class="col s12">
                    @method('PUT')
                    @csrf
                    <div class="row card-panel">
                        <div class="input-field col s10">
                            <input type="text" name="nombre" id="nombre" value="{{$equipo->nombre}}" class="validate" required>
                            <label for="nombre">Denominación del equipo:</label>
                        </div>
                        <div class="input-field col s2">
                            <select name="temporada_id" id="temporada" class="validate" required>
                                <option value="" disabled selected>Elige una</option>
                                @foreach ($temporadas as $temporada)
                                    <option value="{{ $temporada->id }}" {{ ($temporada->id == $equipo->temporada_id) ? 'selected' : ''}}>{{ $temporada->descripcion}}</option>
                                @endforeach
                            </select>
                            <label for="temporada">Temporada:</label>
                        </div>
                        <div class="input-field col s6">
                            <select name="categoria_id" id="Categoria" class="validate" required>
                                <option value="" disabled selected>Elige una</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" {{ ($categoria->id == $equipo->categoria_id) ? 'selected' : '' }}>{{ $categoria->descripcion }}</option>
                                @endforeach
                            </select>
                            <label for="categoria">Categoría</label>
                        </div>
                        <div class="input-field col s6">
                            <select name="genero_id" id="genero" class="validate" required>
                                <option value="" disabled selected>Elige una</option>
                                @foreach ($generos as $genero)
                                    <option value="{{ $genero->id }}" {{ ($genero->id == $equipo->genero_id) ? 'selected' : '' }}>{{ $genero->descripcion }}</option>
                                @endforeach
                            </select>
                            <label for="genero">Género</label>
                        </div>
                        <button class="btn red" type="submit">Guardar</button>
                    </div>        
                </form>
            </div>
        </div>
   


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('select');
        var instances = M.FormSelect.init(elems);
    });
</script>
@endsection

