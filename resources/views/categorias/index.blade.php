@extends('layouts.app')

{{-- @section('titulo', 'Listado de categorías') --}}

@section('content')

@include('common.success')

    <div class="row">
        <div class="container section valign-wrapper">
        <div class="col s10">
                <span><h4>Lista de categorías</h4></span>
        </div>
{{--         <div class="col s2">
                <a href="{{ route('categorias.create') }}" class="btn-floating red waves-effect right"><i class="material-icons">add</i></a>
        </div> --}}
    </div>
        @foreach($categorias as $categoria)
            <div class="col s12 m12 l6">
                <div class="card hoverable z-depth-2">
                    <div class="card-content">
                        <span class="card-title"><strong>{{$categoria->descripcion}}</strong></span>
                        <p>Edad de comienzo: <strong>{{$categoria->edad}} años</strong></p>
                        <p>Duración de la categoría: <strong>{{$categoria->duracion}} años</strong></p>
                        <p>Inscripción (1 plazo): <strong>{{$categoria->precio_inscripcion}} euros</strong> antes del <strong>{{!is_null($categoria->f_plazo_insc)?date('d-m-Y', strtotime($categoria->f_plazo_insc)):''}}</strong></p>
                        <p>Inscripción (2 plazos): <strong>{{$categoria->precio_inscripcion2c}}</strong> euros</p>
                        <p>Primer plazo <strong>{{$categoria->precio_2c1}}</strong> euros a pagar antes del <strong>{{!is_null($categoria->f_plazo_2c1)?date('d-m-Y', strtotime($categoria->f_plazo_2c1)):''}}</strong></p>
                        <p>Segundo plazo <strong>{{$categoria->precio_2c2}}</strong> euros a pagar antes del <strong>{{!is_null($categoria->f_plazo_2c2)?date('d-m-Y', strtotime($categoria->f_plazo_2c2)):''}}</strong></p>
                        <p>Inscripción (3 plazos): <strong>{{$categoria->precio_inscripcion3c}}</strong> euros</p>
                        <p>Primer plazo <strong>{{$categoria->precio_3c1}}</strong> euros a pagar antes del <strong>{{!is_null($categoria->f_plazo_3c1)?date('d-m-Y', strtotime($categoria->f_plazo_3c1)):''}}</strong></p>
                        <p>Segundo plazo <strong>{{$categoria->precio_3c2}}</strong> euros a pagar antes del <strong>{{!is_null($categoria->f_plazo_3c2)?date('d-m-Y', strtotime($categoria->f_plazo_3c2)):''}}</strong></p>
                        <p>Tercer plazo <strong>{{$categoria->precio_3c3}}</strong> euros a pagar antes del <strong>{{!is_null($categoria->f_plazo_3c3)?date('d-m-Y', strtotime($categoria->f_plazo_3c3)):''}}</strong></p>
                    </div>
                    <div class="card-action">
                        <div class="row">
                            <div class="col s2 offset-s8">
                                <a class="btn-floating green" href="/categorias/{{$categoria->id}}/edit"><i class="material-icons">edit</i></a>
                            </div>
                            <div class="col s2">
                                <form action="/categorias/{{$categoria->id}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-floating black"><i class="material-icons">delete</i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach




        {{-- {!! $categorias->render() !!} --}}
    </div>
@endsection
