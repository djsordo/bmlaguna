@extends('layouts.app')

@section('content')

@include('common.errors')


    <div class="section">
        <div class="row">
            {{-- {{dd($tallasElegidas)}} --}}
            <h4>Editar tipo de documento</h4>
            <form action="/documentos/{{$documento->id}}" method="POST" class="col s12" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                
                @documentoMant (['documento' => $documento])
                @enddocumentoMant
            </form>
        </div>
    </div>



@endsection