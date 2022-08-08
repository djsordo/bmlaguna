@extends('layouts.app')

@section('content')

@include('common.success')
<div class="row">

    @barraSuperior (['vista' => $vista, 
                    'baja' => $baja,
                    'textoBusqueda' => $textoBusqueda, 
                    'temporadas' => $temporadas, 'tempActual_id' => $tempActual_id, 
                    'categorias' => $categorias, 'catActual_id' => $catActual_id, 
                    'generos' => $generos, 'genActual_id' => $genActual_id,
                    'nombreBusqueda' => $nombreBusqueda])
    @endbarraSuperior

    
        @if ($vista == 'on')
            @lista (['miembros' => $miembros])
            @endlista
        @else
            @listaCompacta (['miembros' => $miembros])
            @endlistaCompacta
        @endif
    
    <div class="card">
        @paginacion (['elementos' => $miembros, 'path' => $path])
        @endpaginacion
    </div>
</div>
@endsection