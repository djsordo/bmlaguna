@extends('layouts.app')

@section('content')

<script src='/js/miembros.js'></script>

@include('common.errors')

<div class="row">
    <div class="card-title col s10">
        <h1 class="center">{{ $preinscripcion->nombre . ' ' . $preinscripcion->apellido1 . ' ' . $preinscripcion->apellido2 }}</h1>
    </div>

</div>

@endsection
