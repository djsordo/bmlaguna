@extends('layouts.app')

@section('content')

@include('common.success')
@include('common.errors')

<div class="section row">
    <div class="col s12 center">
        <h4>Cambio de temporada</h4>
    </div>

    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">Estado actual</span>
                @if ($temporadaActual)
                    <p><strong>Temporada activa:</strong> {{ $temporadaActual->descripcion }} (año {{ $temporadaActual->temporada }})</p>
                @else
                    <p class="red-text">No hay ninguna temporada registrada.</p>
                @endif

                @if ($temporadas->isNotEmpty())
                    <table class="striped">
                        <thead>
                            <tr>
                                <th>Año inicio</th>
                                <th>Descripción</th>
                                <th>Activa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($temporadas as $temporada)
                                <tr>
                                    <td>{{ $temporada->temporada }}</td>
                                    <td>{{ $temporada->descripcion }}</td>
                                    <td>
                                        @if ($temporadaActual && $temporada->id === $temporadaActual->id)
                                            <i class="material-icons green-text">check_circle</i>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    @if ($temporadaActual && $puedeAvanzar)
        <div class="col s12">
            <div class="card yellow lighten-4">
                <div class="card-content">
                    <span class="card-title">Abrir nueva temporada</span>
                    <p>Esta operación debe realizarse <strong>una sola vez</strong>, al finalizar la temporada en curso. A partir de ese momento, toda la aplicación usará la nueva temporada como referencia.</p>
                    <p>Se creará un registro con:</p>
                    <ul>
                        <li><strong>Año inicio:</strong> {{ $siguienteAnio }}</li>
                        <li><strong>Descripción:</strong> {{ $siguienteDescripcion }}</li>
                    </ul>

                    <form id="formAvanzar" method="POST" action="{{ route('temporada-cambio.avanzar') }}">
                        @csrf
                        <div class="input-field">
                            <input type="text" id="confirmacionAvanzar" name="confirmacion" autocomplete="off"
                                placeholder="{{ $siguienteDescripcion }}">
                            <label for="confirmacionAvanzar">Escriba la descripción de la nueva temporada para confirmar</label>
                        </div>
                        <p>
                            <label>
                                <input type="checkbox" id="aceptoAvanzar" name="acepto" value="1" class="filled-in" />
                                <span>Entiendo que esta acción abrirá la nueva temporada en toda la aplicación</span>
                            </label>
                        </p>
                        <button type="submit" id="btnAvanzar" class="btn red waves-effect waves-light" disabled>
                            Abrir temporada {{ $siguienteDescripcion }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @elseif ($temporadaActual && ! $puedeAvanzar)
        <div class="col s12">
            <div class="materialert warning">
                <div class="material-icons">warning</div>
                La temporada {{ $siguienteDescripcion }} ya está registrada. No es posible avanzar de nuevo.
            </div>
        </div>
    @endif

    @if ($puedeRevertir && $temporadaActual)
        <div class="col s12">
            <div class="card red lighten-5">
                <div class="card-content">
                    <span class="card-title">Volver a la temporada anterior</span>
                    <p>Esta acción <strong>elimina el registro</strong> de la temporada actual ({{ $temporadaActual->descripcion }}) de la base de datos. La aplicación volverá a usar la temporada inmediatamente anterior.</p>

                    @if ($totalDatosVinculados > 0)
                        <div class="materialert error">
                            <div class="material-icons">error_outline</div>
                            <strong>Atención:</strong> la temporada actual tiene datos vinculados. Eliminarla puede dejar registros huérfanos o perder informes.
                        </div>
                        <ul>
                            @foreach ($datosVinculados as $tipo => $cantidad)
                                @if ($cantidad > 0)
                                    <li>{{ ucfirst(str_replace('_', ' ', $tipo)) }}: {{ $cantidad }}</li>
                                @endif
                            @endforeach
                        </ul>
                    @else
                        <p>No hay datos vinculados a la temporada actual.</p>
                    @endif

                    <form id="formRevertir" method="POST" action="{{ route('temporada-cambio.revertir') }}">
                        @csrf
                        <div class="input-field">
                            <input type="text" id="confirmacionRevertir" name="confirmacion" autocomplete="off"
                                placeholder="{{ $temporadaActual->descripcion }}">
                            <label for="confirmacionRevertir">Escriba la descripción de la temporada a eliminar</label>
                        </div>
                        <p>
                            <label>
                                <input type="checkbox" id="aceptoRevertir" name="acepto" value="1" class="filled-in" />
                                <span>Entiendo que se eliminará la temporada {{ $temporadaActual->descripcion }}</span>
                            </label>
                        </p>
                        @if ($totalDatosVinculados > 0)
                            <p>
                                <label>
                                    <input type="checkbox" id="aceptoDatos" name="acepto_datos" value="1" class="filled-in" />
                                    <span>Entiendo el riesgo de eliminar una temporada con datos vinculados</span>
                                </label>
                            </p>
                        @endif
                        <button type="submit" id="btnRevertir" class="btn grey darken-3 waves-effect waves-light" disabled>
                            Eliminar temporada {{ $temporadaActual->descripcion }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
$(document).ready(function () {
    var descAvanzar = @json($siguienteDescripcion ?? '');
    var descRevertir = @json($temporadaActual ? $temporadaActual->descripcion : '');
    var requiereAceptoDatos = @json(($totalDatosVinculados ?? 0) > 0);

    function validarAvanzar() {
        var ok = $('#confirmacionAvanzar').val() === descAvanzar && $('#aceptoAvanzar').is(':checked');
        $('#btnAvanzar').prop('disabled', !ok);
    }

    function validarRevertir() {
        var ok = $('#confirmacionRevertir').val() === descRevertir && $('#aceptoRevertir').is(':checked');
        if (requiereAceptoDatos) {
            ok = ok && $('#aceptoDatos').is(':checked');
        }
        $('#btnRevertir').prop('disabled', !ok);
    }

    $('#confirmacionAvanzar, #aceptoAvanzar').on('input change', validarAvanzar);
    $('#confirmacionRevertir, #aceptoRevertir, #aceptoDatos').on('input change', validarRevertir);
});
</script>

@endsection
