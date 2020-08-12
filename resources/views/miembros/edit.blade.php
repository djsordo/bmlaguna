@extends('layouts.app')

@section('content')

<script src='/js/miembros.js'></script>

@include('common.errors')


        <div class="section">
            <div class="row">
                <form method="POST" action="/miembros/{{ $miembro->id }}"  class="col s12" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf

                    @datosPersonales (['miembro' => $miembro, 'generos' => $generos, 'dorsales' => $dorsales])
                    @enddatosPersonales

                    @ubicacion (['miembro' => $miembro])
                    @endubicacion

                    @responsables (['miembro' => $miembro, 'responsables' => $responsables])
                    @endresponsables

                    @contactos(['telefonos' => $telefonos, 'emails' => $emails])
                    @endcontactos

                    <div class="col s12">
                        <button class="btn red" type="submit">Guardar</button>
                    </div>
                            
                </form>
            </div>
        </div>

@endsection