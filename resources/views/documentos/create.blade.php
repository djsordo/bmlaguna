@extends('layouts.app')

@section('content')

@include('common.errors')

<div class="col s12">
    <div class="section">
        <div class="row">
            <h4>Crear tipo de documento</h4>
            <form action="/documentos" method="POST" class="col s12" enctype="multipart/form-data">
                @csrf
                @documentoMant (['documento' => null])
                @enddocumentoMant
            </form>
        </div>
    </div>
</div>


@endsection