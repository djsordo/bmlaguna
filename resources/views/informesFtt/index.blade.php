@extends('layouts.app')

@section('content')
@include('common.success')

<div class="section row">
    <div class="col s12 left-align" style="margin-bottom: 0.75rem;">
        <a href="{{ route('miembros') }}" class="valign-wrapper black-text waves-effect waves-dark" style="display: inline-flex; align-items: center;">
            <i class="material-icons" style="margin-right: 6px;">arrow_back</i>
            <span class="flow-text">Volver al listado</span>
        </a>
    </div>

    @if ($temporadas->isEmpty())
        <div class="card-panel col s12 amber lighten-4">
            <p>No hay temporadas definidas.</p>
        </div>
    @else
        <div class="card-panel col s12">
            <h4 class="center">Informes Físico-Técnico Tácticos</h4>
            <p class="center grey-text">{{ $miembro->nombre }} {{ $miembro->apellido1 }} {{ $miembro->apellido2 }}</p>

            <div class="row" style="margin-top: 1.25rem; margin-bottom: 0;">
                <div class="col s12 m6 left-align valign-wrapper" style="min-height: 56px;">
                    @if ($tempSel)
                        <p class="flow-text" style="margin: 0;">
                            <strong>Categoría en la temporada:</strong>
                            @if ($categoriaEquipo)
                                {{ $categoriaEquipo->descripcion }}
                            @else
                                <span class="grey-text">— (no consta como jugador en equipo esta temporada)</span>
                            @endif
                        </p>
                    @else
                        <p class="flow-text grey-text" style="margin: 0;">—</p>
                    @endif
                </div>
                <div class="col s12 m6 right-align">
                    <form method="GET" action="{{ route('informesFtt', $miembro->id) }}" id="formTemporadaFtt" class="right-align">
                        <div class="input-field" style="max-width: 280px; margin-left: auto; margin-right: 0;">
                            <select name="temporada_id" id="temporada_id_ftt" onchange="this.form.submit()">
                                @foreach ($temporadas as $t)
                                    <option value="{{ $t->id }}" {{ $tempSel && $tempSel->id == $t->id ? 'selected' : '' }}>
                                        {{ $t->descripcion }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="temporada_id_ftt">Temporada</label>
                        </div>
                    </form>
                </div>
            </div>

            @if ($tempSel)
                @if ($informe && $informe->exists && $informe->tecnico)
                    <p class="grey-text text-darken-1" style="margin-top: 0.5rem; margin-bottom: 1rem;">
                        Última edición: {{ trim($informe->tecnico->nombre.' '.$informe->tecnico->apellido1.' '.$informe->tecnico->apellido2) }}
                        @if ($informe->updated_at)
                            — {{ $informe->updated_at->format('d/m/Y H:i') }}
                        @endif
                    </p>
                @endif

                <form id="informeFttSave" method="POST" action="{{ route('informesFtt.update', $miembro->id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="temporada_id" value="{{ $tempSel->id }}">

                    <div class="row" style="margin-bottom: 0;">
                        <div class="input-field col s12">
                            <p class="grey-text text-darken-1" style="margin-bottom: 0.5rem;">
                                @if ($origenTecnicos === 'equipo')
                                    Técnicos del equipo (oficiales)
                                @else
                                    Técnicos del club
                                @endif
                            </p>
                            @if ($tecnicosDisponibles->isEmpty())
                                <p class="amber-text text-darken-2">No hay técnicos disponibles para asignar. Marca el informe sin técnico o da de alta técnicos en el club.</p>
                                <input type="hidden" name="tecnico_id" value="">
                            @else
                                <select name="tecnico_id" id="tecnico_id_ftt" {{ $tecnicosDisponibles->isNotEmpty() ? 'required' : '' }}>
                                    <option value="" disabled {{ old('tecnico_id', $informe->tecnico_id ?? '') === '' || old('tecnico_id', $informe->tecnico_id ?? '') === null ? 'selected' : '' }}>Elige un técnico</option>
                                    @foreach ($tecnicosDisponibles as $tec)
                                        <option value="{{ $tec->id }}" {{ (string) old('tecnico_id', $informe->tecnico_id ?? '') === (string) $tec->id ? 'selected' : '' }}>
                                            {{ trim($tec->nombre.' '.$tec->apellido1.' '.$tec->apellido2) }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="tecnico_id_ftt">Técnico del informe</label>
                            @endif
                        </div>
                    </div>

                    <div class="row" style="margin-bottom: 0;">
                        <div class="input-field col s12">
                            <textarea name="texto" id="texto_ftt" class="materialize-textarea" style="width: 100%; min-height: 220px;">{{ old('texto', $informe ? $informe->texto : '') }}</textarea>
                            <label for="texto_ftt">Texto del informe</label>
                        </div>
                    </div>

                    @include('common.errors')
                </form>
            @endif
        </div>

        @if ($tempSel)
        <div class="col s12 left-align">
            <button class="btn red" type="submit" form="informeFttSave">Guardar</button>
        </div>
        @endif
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var selT = document.getElementById('temporada_id_ftt');
        if (selT && typeof M !== 'undefined' && M.FormSelect) {
            M.FormSelect.init(selT);
        }
        var selTech = document.getElementById('tecnico_id_ftt');
        if (selTech && typeof M !== 'undefined' && M.FormSelect) {
            M.FormSelect.init(selTech);
        }
        var ta = document.getElementById('texto_ftt');
        if (ta && typeof M !== 'undefined' && M.textareaAutoResize) {
            M.textareaAutoResize(ta);
        }
    });
</script>
@endsection
