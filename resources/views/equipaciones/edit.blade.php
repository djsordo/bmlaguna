@extends('layouts.app')

@section('content')

@include('common.errors')

<div class="col s12">
    <div class="section">
        <div class="row">
            {{-- {{dd($tallasElegidas)}} --}}
            <h4>Editar equipación</h4>
            <form action="/equipaciones/{{$equipacione->id}}" method="POST" class="col s12" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                
                @equipacionMant (['equipacione' => $equipacione, 'temporadas' => $temporadas, 'tallas' => $tallas, 'tempActual' => $tempActual, 'tallasElegidas' => $tallasElegidas])
                @endequipacionMant
            </form>
        </div>
    </div>
</div>


@endsection