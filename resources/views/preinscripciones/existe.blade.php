@extends('layouts.appSinBarra')

@section('content')

<script src='/js/miembros.js'></script>

@include('common.errors')

<div class="row">
    <div class="col s4">
        <img src="/images/escudo.png" alt="Balonmano Laguna" class="responsive-img">
    </div>
    <div class="col s8">
        <h2>CLUB BALONMANO LAGUNA</h2>
    </div>
    <div class="col s8">
        <h3>Formulario de Preinscripción</h3>
    </div>
</div>

<div class="col s12 m8">
    <div class="section">
        <div class="row">
            <div class="row card-panel">
                <span class="flow-text">Ya tenemos registrada una preinscripción para este jugador.</span>
                <p>Revise su correo electrónico.</p>
                <p>Número de preinscripción {{$preExiste->nPreinscripcion}}.</p>
            </div>
        </div>
    </div>
</div>

@endsection
