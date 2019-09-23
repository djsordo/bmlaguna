@extends('layouts.app')

@section('content')

@include('common.success')

<div class="row">
    <p>
        {{$miembro->nombre.' '.$miembro->apellido1.' '.$miembro->apellido2}}
        </p>
        
    <div class="col s1 center">
        <a href="{{ route('reconocimientos.create') }}" class="btn-floating red waves-effect"><i class="material-icons">add</i></a> 
    </div>

    @foreach ($reconocimientos as $reconocimiento)
    {{$reconocimiento->f_reconocimiento}}
@endforeach
</div>



@endsection