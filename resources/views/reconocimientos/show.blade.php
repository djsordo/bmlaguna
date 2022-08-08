@extends('layouts.app')

@section('content')

@include('common.success')

<div class="row">
    <p>
        {{$miembro->nombre.' '.$miembro->apellido1.' '.$miembro->apellido2}}
    </p>
    
    <ul class="collapsible" data-collapsible="accordion">
        <li>
            <div class="collapsible-header">
                <span class="col s6"><b>Temporada</b></span>
                <span class="col s6"><b>Fecha de reconocimiento</b></span>
            </div>
        </li>
        @foreach ($reconocimientos as $reco)
        <li>
            <div class="collapsible-header">
                <span class="col s6">{{$reco->temporada->descripcion}}</span>
                <span class="col s6">{{date('d-m-Y', strtotime($reco->f_reconocimiento))}}</span>                
            </div>
            <div class="collapsible-body">
                <div class="row">
                    <div class="col s12 card">
                        <div class="col s2">
                            <label for="peso">Peso :</label><br>
                            <span id="peso" class="black-text">{{ (!is_null($reco->peso)) ? $reco->peso : ' - ' }}</span>
                        </div>
                        <div class="col s2">
                            <label for="talla">Talla :</label><br>
                            <span id="talla" class="black-text">{{ (!is_null($reco->talla)) ? $reco->talla : ' - ' }}</span>
                        </div>
                        <div class="col s2">
                            <label for="tension">Tensión :</label><br>
                            <span id="tension" class="black-text">{{ (!is_null($reco->tensionH)) ? $reco->tensionH : ' - ' }}/{{ (!is_null($reco->tensionL)) ? $reco->tensionL : ' - ' }}</span>
                        </div>
                        <div class="col s2">
                            <label for="saturacion">Saturación :</label><br>
                            <span id="saturacion" class="black-text">{{ (!is_null($reco->saturacion)) ? $reco->saturacion : ' - ' }}</span>
                        </div>
                        <div class="col s2">
                            <label for="fc">FC :</label><br>
                            <span id="fc" class="black-text">{{ (!is_null($reco->FC)) ? $reco->FC : ' - ' }}</span>
                        </div>
                        <div class="col s2">
                            <label for="fc-pest">FC-PEST :</label><br>
                            <span id="fc-pest" class="black-text">{{ (!is_null($reco->FCPEST)) ? $reco->FCPEST : ' - ' }}</span>
                        </div>
                    </div>
                    <div class="col s12 card">
                        <div class="col s4">
                            <label for="medicacion">Medicación :</label><br>
                            <span id="medicacion" class="black-text">{{ (!is_null($reco->medicacion)) ? $reco->medicacion : ' - ' }}</span>
                        </div>
                        <div class="col s4">
                            <label for="vista">Vista :</label><br>
                            <span id="vista" class="black-text">{{ (!is_null($reco->vista)) ? $reco->vista : ' - ' }}</span>
                        </div>
                        <div class="col s4">
                            <label for="oido">Oido :</label><br>
                            <span id="oido" class="black-text">{{ (!is_null($reco->oido)) ? $reco->oido : ' - ' }}</span>
                        </div>
                    </div>
                    <div class="col s12 card">
                        <div class="col s6">
                            <label for="columna">Columna :</label><br>
                            <span id="columna" class="black-text">{{ (!is_null($reco->columna)) ? $reco->columna : ' - ' }}</span>
                        </div>
                        <div class="col s6">
                            <label for="aca">ACA :</label><br>
                            <span id="aca" class="black-text">{{ (!is_null($reco->ACA)) ? $reco->ACA : ' - ' }}</span>
                        </div>
                    </div>
                    <div class="col s12 card">
                        <div class="col s12">
                            <label for="observaciones">Observaciones :</label><br>
                            <span id="observaciones" class="black-text">{{ (!is_null($reco->observaciones)) ? $reco->observaciones : ' - ' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    @endforeach
    </ul>

    <div class="col s1 center">
        <a href="/reconocimientos/create/{{$miembro->id}}" class="btn-floating red waves-effect"><i class="material-icons">add</i></a> 
    </div>

    <div class="col s1 center">
        <a href="{{ route('pdf-certFedeReco', compact('miembro')) }}" class="btn-floating green waves-effect"><i class="material-icons">print</i></a> 
    </div>
</div>
<script>
    $('.collapsible').collapsible();
</script>

@endsection