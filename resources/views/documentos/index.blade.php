@extends('layouts.app')

@section('content')

@include('common.success')

<div class="col s12 m8">
    <div class="section row">

        <div class="col s10 center">
            <h4>Mantenimiento de tipos de documentos</h4>
        </div>
        <div class="col s2 center">
            <a href="{{ route('documentos.create') }}" class="btn-floating red waves-effect right"><i class="material-icons">add</i></a> 
        </div>

        <table>
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Tipo</th>
                    <th>Subtipo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($documentos as $documento)
                    <tr>
                        <td>{{$documento->descripcion }}</td>
                        <td>{{$documento->tipo }}</td>
                        <td>{{$documento->subTipo }}</td>
                        <td><a href="/documentos/{{$documento->id}}/edit" class="secondary-content"><i class="material-icons green-text">edit</i></a></td>                  
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection