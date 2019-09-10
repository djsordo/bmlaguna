@extends('layouts.app')

@section('content')

<script src='/js/miembros.js'></script>

@include('common.errors')

    <div class="col s12 m8">
        <div class="section">
            <div class="row">
                <form method="POST" action="/miembros"  class="col s12" enctype="multipart/form-data">
                    @csrf

                    @datosPersonales (['ruta' => null, 'rutaDNIF' => null, 'rutaDNIP' => null, 'miembro' => null, 'generos' => $generos, 'dorsales' => $dorsales])
                    @enddatosPersonales

                    @ubicacion (['miembro' => null])
                    @endubicacion

                    @responsables (['miembro' => null, 'responsables' => $responsables])
                    @endresponsables

                    @contactos(['telefonos' => null, 'emails' => null])
                    @endcontactos

                    <div class="col s12">
                        <button class="btn red" type="submit">Guardar</button>
                    </div>
                            
                </form>
            </div>
        </div>
    </div>
@endsection