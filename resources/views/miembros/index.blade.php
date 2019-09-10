@extends('layouts.app')

@section('content')

@include('common.success')
<div class="row">

    @barraSuperior (['vista' => $vista, 'textoBusqueda' => $textoBusqueda])
    @endbarraSuperior

    @if ($vista == 'on')
        @listaCompacta (['miembros' => $miembros])
        @endlistaCompacta
    @else
        @lista (['miembros' => $miembros])
        @endlista
    @endif

    @paginacion (['elementos' => $miembros, 'path' => $path])
    @endpaginacion
    
</div>
@endsection