@extends('layouts.app')

{{-- @section('titulo', 'Crear Equipo') --}}

@section('content')

@include('common.errors')


        <div class="section">
            <div class="row">
                <form method="POST" action="/equipos" class="col s12">
                    @csrf
                    <div class="row card-panel">
                        <div class="input-field col s10">
                            <input type="text" name="nombre" id="nombre" class="validate" required>
                            <label for="nombre">Denominación del equipo:</label>
                        </div>
                        <div class="input-field col s2">
                            <select name="temporada_id" id="temporada">
                                <option value="" disabled selected>Elige una</option>
                                @foreach ($temporadas as $temporada)
                                    <option value="{{ $temporada->id }}">{{ $temporada->descripcion}}</option>
                                @endforeach
                            </select>
                            <label for="temporada">Temporada:</label>
                        </div>
                        <div class="input-field col s6">
                            <select name="categoria_id" id="Categoria">
                                <option value="" disabled selected>Elige una</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}">{{ $categoria->descripcion }}</option>
                                @endforeach
                            </select>
                            <label for="categoria">Categoría</label>
                        </div>
                        <div class="input-field col s6">
                            <select name="genero_id" id="genero" class="validate" required>
                                <option value="" disabled selected>Elige una</option>
                                @foreach ($generos as $genero)
                                    <option value="{{ $genero->id }}">{{ $genero->descripcion }}</option>
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

