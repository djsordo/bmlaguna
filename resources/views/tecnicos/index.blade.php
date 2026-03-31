@extends('layouts.app')

@section('content')

@include('common.success')

<div class="row">
    <form id="criteriosTecnicosForm" method="GET" action="{{ route('tecnicos.index') }}">
        <div class="section">
            <div class="card col s12 grey lighten-5">
                <div class="card-content grey lighten-5">
                    <span class="card-title">
                        <div class="row valign-wrapper">
                            <div class="col s12 m9">Criterios de búsqueda</div>
                            <div class="col s12 m3">
                                <div class="input-field">
                                    <select name="temporada_id" id="tempSelectTecnicos">
                                        @foreach ($temporadas as $temp)
                                            <option value="{{ $temp->id }}" {{ (string) $temporadaId === (string) $temp->id ? 'selected' : '' }}>{{ $temp->descripcion }}</option>
                                        @endforeach
                                    </select>
                                    <label for="tempSelectTecnicos">Temporada</label>
                                </div>
                            </div>
                        </div>
                    </span>

                    <div class="row">
                        <div class="col s12 m6">
                            <div class="input-field">
                                <i class="material-icons prefix">search</i>
                                <input type="text" id="nombreBusqueda" name="nombreBusqueda" autocomplete="off" value="{{ $nombreBusqueda }}">
                                <label for="nombreBusqueda">Nombre del técnico</label>
                            </div>
                        </div>
                        <div class="col s12 m6">
                            <div class="input-field">
                                <select name="equipo_id" id="equipoSelectTecnicos">
                                    <option value="" {{ $equipoId === null || $equipoId === '' ? 'selected' : '' }}>-- Todos los equipos --</option>
                                    @foreach ($equipos as $eq)
                                        <option value="{{ $eq->id }}" {{ (string) $equipoId === (string) $eq->id ? 'selected' : '' }}>{{ $eq->nombre }}</option>
                                    @endforeach
                                </select>
                                <label for="equipoSelectTecnicos">Equipo</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12">
                            <button type="submit" class="btn waves-effect waves-light red">Buscar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @if ($tecnicos !== null)
        <div class="col s12">
            @if ($tecnicos->total() === 0)
                <div class="card-panel center grey-text">No hay técnicos con los criterios seleccionados.</div>
            @else
                <ul class="collapsible popout">
                    @foreach ($tecnicos as $grupo)
                        @php
                            $unaSolaAsignacion = $grupo->asignaciones->count() === 1;
                            $asigUnica = $unaSolaAsignacion ? $grupo->asignaciones->first() : null;
                        @endphp
                        <li class="{{ $unaSolaAsignacion ? 'tecnico-solo-equipo' : 'tecnico-varios-equipos' }}">
                            <div class="collapsible-header tecnico-acordeon-cabecera">
                                <div class="row tecnico-acordeon-fila valign-wrapper">
                                    <div class="col s10 m11">
                                        <strong class="flow-text black-text">{{ $grupo->nombre_completo }}</strong>
                                    </div>
                                    @if ($unaSolaAsignacion && $asigUnica)
                                        <div class="col s2 m1 right-align">
                                            <a href="{{ url('/equipos/'.$asigUnica->equipo_id) }}" class="tooltipped tecnico-enlace-equipo-cabecera" data-tooltip="Ficha del equipo">
                                                <i class="material-icons circle blue white-text" style="font-size: 26px; width: 48px; height: 48px; line-height: 1; display: inline-flex; align-items: center; justify-content: center;">group</i>
                                            </a>
                                        </div>
                                    @elseif (!$unaSolaAsignacion)
                                        <div class="col s2 m1 right-align tecnico-acordeon-desplegable-marca">
                                            <span class="tecnico-acordeon-desplegable tooltipped" data-tooltip="Pulsa para ver los equipos" data-position="left">
                                                <i class="material-icons tecnico-acordeon-chevron-icon grey-text text-darken-1" aria-hidden="true">expand_more</i>
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <div class="row tecnico-acordeon-fila">
                                    <div class="col s12 tecnico-acordeon-meta">
                                        @if ($unaSolaAsignacion && $asigUnica)
                                            @php
                                                $tituloFuncion = ucfirst($asigUnica->funcion_descripcion);
                                            @endphp
                                            <span class="chip z-depth-0 grey lighten-3 grey-text text-darken-3 tecnico-chip-equipo">
                                                {{ $asigUnica->equipo_nombre }}
                                            </span>
                                            <span class="chip z-depth-0 red lighten-4 black-text tecnico-chip-funcion">{{ $tituloFuncion }}</span>
                                        @else
                                            <span class="chip z-depth-0 blue-grey lighten-5 blue-grey-text text-darken-2">
                                                <i class="material-icons left">layers</i>
                                                Varios equipos
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if ($unaSolaAsignacion)
                                <div class="collapsible-body tecnico-acordeon-body-vacio"></div>
                            @else
                                <div class="collapsible-body tecnico-acordeon-body-detalle">
                                    <ul class="collection tecnico-acordeon-collection">
                                        @foreach ($grupo->asignaciones as $a)
                                            @php
                                                $funcionTxt = ucfirst($a->funcion_descripcion);
                                            @endphp
                                            <li class="collection-item tecnico-acordeon-item">
                                                <div class="tecnico-acordeon-item-inner">
                                                    <div class="row tecnico-acordeon-fila valign-wrapper">
                                                        <div class="col s10 m11">
                                                            <strong class="black-text tecnico-detalle-equipo-nombre">{{ $a->equipo_nombre }}</strong>
                                                        </div>
                                                        <div class="col s2 m1 right-align">
                                                            <a href="{{ url('/equipos/'.$a->equipo_id) }}" class="tooltipped tecnico-enlace-equipo-detalle" data-tooltip="Ficha del equipo">
                                                                <i class="material-icons circle blue white-text" style="font-size: 26px; width: 48px; height: 48px; line-height: 1; display: inline-flex; align-items: center; justify-content: center;">group</i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="row tecnico-acordeon-fila">
                                                        <div class="col s12 tecnico-acordeon-meta">
                                                            <span class="chip z-depth-0 red lighten-4 black-text tecnico-chip-funcion">{{ $funcionTxt }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        @if ($tecnicos->total() > 0)
            <div class="col s12 section">
                <div class="card grey lighten-5">
                    @paginacion (['elementos' => $tecnicos, 'path' => $path])
                    @endpaginacion
                </div>
            </div>
        @endif
    @else
        <div class="col s12 card-panel center grey-text">
            No hay temporada seleccionable.
        </div>
    @endif
</div>

<style>
    .tecnico-acordeon-cabecera {
        display: block !important;
        height: auto !important;
        min-height: unset !important;
        padding: 14px 20px 14px 16px !important;
        border-left: 4px solid #e53935;
        background-color: #fafafa;
        transition: background-color 0.2s ease;
    }
    .tecnico-acordeon-cabecera::after {
        display: none !important;
    }
    .collapsible li.active .tecnico-acordeon-cabecera {
        background-color: #fff5f5;
    }
    .tecnico-acordeon-fila {
        margin-bottom: 0;
    }
    .tecnico-acordeon-meta {
        margin-top: 10px;
    }
    .tecnico-acordeon-meta .chip {
        margin-right: 8px;
        margin-bottom: 2px;
        height: auto !important;
        line-height: 1.5 !important;
        padding: 6px 12px !important;
        display: inline-flex !important;
        align-items: center !important;
    }
    .tecnico-acordeon-meta .chip .material-icons.left {
        float: none !important;
        margin-right: 6px !important;
        font-size: 18px !important;
    }
    .tecnico-chip-funcion {
        font-weight: 500;
    }
    .tecnico-varios-equipos > .collapsible-header {
        cursor: pointer;
    }
    .tecnico-acordeon-desplegable-marca {
        line-height: 1;
    }
    .tecnico-acordeon-chevron-icon {
        font-size: 28px;
        transition: transform 0.22s ease;
    }
    .tecnico-varios-equipos.active .tecnico-acordeon-chevron-icon {
        transform: rotate(180deg);
    }
    .tecnico-solo-equipo > .collapsible-header {
        cursor: default;
    }
    .tecnico-solo-equipo .tecnico-enlace-equipo-cabecera {
        cursor: pointer;
    }
    .tecnico-acordeon-body-vacio {
        padding: 0 !important;
        border: none !important;
        min-height: 0 !important;
    }
    .tecnico-acordeon-body-detalle {
        padding: 12px 12px 8px !important;
        background-color: #fff;
    }
    .tecnico-acordeon-collection {
        border: none !important;
        margin: 0 !important;
        overflow: visible !important;
    }
    .tecnico-acordeon-collection .collection-item.tecnico-acordeon-item {
        border: none !important;
        padding: 0 !important;
        margin-bottom: 10px !important;
        background: transparent !important;
    }
    .tecnico-acordeon-collection .collection-item.tecnico-acordeon-item:last-child {
        margin-bottom: 0 !important;
    }
    .tecnico-acordeon-item-inner {
        padding: 14px 20px 14px 16px !important;
        border-left: 4px solid #e53935;
        background-color: #fafafa;
        transition: background-color 0.2s ease;
    }
    .tecnico-acordeon-item-inner:hover {
        background-color: #fff5f5;
    }
    .tecnico-detalle-equipo-nombre {
        font-size: 1.25rem;
        font-weight: 500;
        line-height: 1.35;
    }
    .tecnico-enlace-equipo-detalle {
        cursor: pointer;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.tecnico-solo-equipo > .collapsible-header').forEach(function(h) {
            h.addEventListener('click', function(e) {
                if (e.target.closest('a')) return;
                e.preventDefault();
                e.stopImmediatePropagation();
            }, true);
        });
        document.querySelectorAll('.tecnico-enlace-equipo-cabecera').forEach(function(a) {
            a.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });

        var elems = document.querySelectorAll('select');
        M.FormSelect.init(elems);
        var coll = document.querySelectorAll('.collapsible');
        M.Collapsible.init(coll);
        var tips = document.querySelectorAll('.tooltipped');
        M.Tooltip.init(tips);
    });

    document.getElementById('tempSelectTecnicos').onchange = function() {
        document.getElementById('criteriosTecnicosForm').submit();
    };
</script>

@endsection
