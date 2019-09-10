@extends('layouts.app')

@section('content')

@include('common.errors')

<div class="col s12">
    <div class="section">
        <div class="row">
            <h4>Crear equipación</h4>
            <form action="/equipaciones" method="POST" class="col s12" enctype="multipart/form-data">
                @csrf
                @equipacionMant (['equipacione' => null, 'temporadas' => $temporadas, 'tallas' => $tallas, 'tempActual' => $tempActual, 'tallasElegidas' => NULL])
                @endequipacionMant
            </form>
        </div>
    </div>
</div>


@endsection
