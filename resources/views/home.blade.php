@extends('layouts.app')

@section('content')
{{-- {{ Breadcrumbs::render('home') }} --}}
<div class="section row">
    <div class="col s12 center">
        <img src="/images/FotoBMLaguna.jpg" width="100%" alt="Balonmano Laguna" class="responsive-img z-depth-2">
    </div>
</div>


    {{-- <div class="row center">
        <div class="col s2">
            <img src="https://i2.wp.com/www.balonmanolaguna.es/wp-content/uploads/2014/01/escudo-e1477594191944.png?resize=203%2C203" alt="Balonmano Laguna" class="responsive-img">
        </div>

        <div class="col s12">
            <div class="flow-text"> Conectado como {{ Auth::user()->name }}</div>

            <div class="flow-text">Somos {{$nMiembros}} en el club</div>
            
            <div class="card col s8 l6 offset-s2 offset-l3">
                <div class="card-image waves-effect waves-block waves-light">
                    <img class="activator" src="images/Preinscripcion.png">
                </div>

                <div class="card-content">
                    <span class="card-title activator grey-text text-darken-4">A día de hoy tenemos {{$nPreinscritos}} preinscritos<i class="material-icons right">more_vert</i></span>
                    <a href="/export-preinscripciones" class="right"><img src="images/excel.png" width="30px"></a>
                </div>

                <div class="card-reveal">
                    <span class="card-title grey-text text-darken-4">Desglose:<i class="material-icons right">close</i></span>
                    @foreach ($categorias as $categoria)
                        <div class="col s4 flow-text">
                            <div>{{$categoria->descripcion}}</div>
                            <div>{{$categoria->preinscritos('masculino')->count()}} <i class="material-icons">wc</i> {{$categoria->preinscritos('femenino')->count()}}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card col s8 l6 offset-s2 offset-l3">
                <div class="card-image waves-effect waves-block waves-light">
                    <img class="activator" src="images/equipaciones.jpg">
                </div>

                <div class="card-content">
                    <span class="card-title activator grey-text text-darken-4">Se han probado {{$nProbados}} sobre {{$nPreinscritos}} preinscritos<i class="material-icons right">more_vert</i></span>
                    <a href="/export-probados" class="right tooltipped" data-tooltip="Por miembros"><img src="images/excel.png" width="30px"></a>
                    <a href="/export-probadosPrenda" class="right tooltipped" data-tooltip="Por prenda"><img src="images/excel.png" width="30px"></a>
                </div>

                <div class="card-reveal">
                    <span class="card-title grey-text text-darken-4">Desglose:<i class="material-icons right">close</i></span>
                    @foreach ($categorias as $categoria)
                        <div class="col s4 flow-text">
                            <div>{{$categoria->descripcion}}</div>
                            <div>{{$categoria->probados('masculino')->count().'/'.$categoria->preinscritos('masculino')->count()}} <i class="material-icons">wc</i> {{$categoria->probados('femenino')->count().'/'.$categoria->preinscritos('femenino')->count()}}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card col s8 l6 offset-s2 offset-l3">
                <div class="card-image waves-effect waves-block waves-light">
                    <img class="activator" src="images/documentacion.png">
                </div>

                <div class="card-content">
                    <span class="card-title activator grey-text text-darken-4">Estado de la documentación<i class="material-icons right">more_vert</i></span>
                    <a href="/export-estadoDNI" class="right"><img src="images/excel.png" width="30px"></a>
                </div>

                <div class="card-reveal">
                    <span class="card-title grey-text text-darken-4">Desglose:<i class="material-icons right">close</i></span>
                    <div class="flow-text">DNI Correctos: {{$estadoDOC['DNIActivo']}}</div>
                    <div class="flow-text">DNI Caducados: {{$estadoDOC['DNICaducado']}}</div>
                    <div class="flow-text">Sin DNI: {{$estadoDOC['sinDNI']}}</div>
                </div>
            </div>

            @foreach ($categorias as $categoria)
                <div class="col s4">
                    <div class="card-content blue darken-1 white-text z-depth-2">
                        <p class="flow-text">{{ $categoria->descripcion }}</p>
                        <p class="flow-text">{{ $categoria->miembros($temporada)->count() }} <i class="material-icons">group</i></p>
                        <p class="flow-text">{{ $categoria->masculinos($temporada)->count() }} <i class="material-icons">wc</i> {{ $categoria->femeninos($temporada)->count() }} </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.tooltipped');
            var instances = M.Tooltip.init(elems);
        });
    </script>
        
@endsection

