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
                <span class="flow-text">Muchas gracias por realizar la preinscripción.</span>
                <p>Se le ha asignado el número de preinscripción {{$nPreinscripcion}}.</p>

                <p align="justify">Se le ha enviado un correo electrónico a la dirección indicada en el formulario de preinscripción donde se encuentran las instrucciones de pago.</p>
                <p align="justify">Una vez que el pago sea verificado enviaremos otro correo electrónico con el documento acreditativo de la inscripción.</p>
            </div>
        </div>
    </div>
</div>

@endsection
