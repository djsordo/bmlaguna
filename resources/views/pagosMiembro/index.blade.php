@extends('layouts.app')

@section('content')
@include('common.errors')


    <div class="section row">
        <div class="card-panel col s12">
            <h3 class="center">Pagos de {{$miembro->nombre.' '.$miembro->apellido1.' '.$miembro->apellido2}}</h3>
        </div>
        <div class="card-panel col s12 valign-wrapper">
            <div class="col s10">
                <form id="tempForm" action="/pagosMiembro/{{$miembro_id}}">
                    <div class="input-field col s10">
                        <select name="tempSelect_id" id="tempSelect">
                            @foreach ($temporadas as $temporada)
                                <option value="{{ $temporada->id }}" {{ ($temporada->id == $tempAct->id) ? 'selected' : ''}}>{{ $temporada->descripcion}}</option>
                            @endforeach
                        </select>
                        <label for="tempselect">Temporada</label>
                    </div>

                    <div class="input-field col s3">
                        <input type="number" id="miembro_id" name="miembro_id" value='{{$miembro_id}}' class="validate" required hidden>
                    </div>
                </form>
            </div>
            <div class="col s2">
                <a class="btn-floating btn-large waves-effect waves-light red modal-trigger" href="#addPago"><i class="material-icons">add</i></a>
            </div>
        </div>

        <div class="card-panel col s12">
            <div class="col s4">
                <div class="flow-text">Cuota temporada: {{ $cuota }}</div>
            </div>

            <div class="col s4">
                <div class="flow-text">Total ya pagado: {{ $pagado }}</div>
            </div>

            <div class="col s4">
                <div class="flow-text">Pendiente de pagar: {{$cuota - $pagado }}</div>
            </div>
        </div>

        <!-- Modal de nuevo pago -->
        <div id="addPago" class="col s8 modal">
            <div class="modal-content">
                <h4>Nuevo Pago</h4>
                <div class="row">
                    <form method="POST" action="/pagosMiembro" class="col s12">
                        @csrf
                        <div class="input-field col s3">
                            <select name="temporada_id" id="temporada">
                                <option value="" disabled selected>Elige una</option>
                                @foreach ($temporadas as $temporada)
                                    <option value="{{ $temporada->id }}" {{ ($temporada == $tempAct) ? 'selected' : '' }}>{{ $temporada->descripcion}}</option>
                                @endforeach
                            </select>
                        <label for="temporada">Temporada:</label>
                        </div>
                        <div class="input-field col s3"></div>

                        <div class="input-field col s6">
                            <select name="tipospago_id" id="tipospago">
                                <option value="" disabled selected>Elige una</option>
                                @foreach ($tipospagos as $tipospago)
                                    <option value="{{ $tipospago->id }}" {{($tipospago->descripcion == 'Inscripción') ? 'selected' : '' }} >{{ $tipospago->descripcion }}</option>
                                @endforeach
                            </select>
                            <label for="tipospago">Tipo de Pago</label>
                        </div>

                        <div class="input-field col s3">
                            <input type="text" class="datepicker validate" id="f_pago" name="f_pago" value="{{ date('d-m-Y') }}">
                            <label for="f_pago">Fecha de pago:</label>
                        </div>

                        <div class="input-field col s3">
                            <input type="text" class="datepicker validate" id="f_vencimiento" name="f_vencimiento" value="{{ date('d-m-Y') }}">
                            <label for="f_vencimiento">Fecha de vencimiento:</label>
                        </div>

                        <div class="input-field col s3">
                            <input type="number" placeholder="Importe" id="importe" name="importe" class="validate" value="{{$cuota - $pagado}}" step=".01" required>
                            <label for="importe">Importe del pago:</label>
                        </div>

                        <div class="input-field col s3">
                            <select name="estado" id="estado">
                                <option value="Pendiente" selected>Pendiente</option>
                                <option value="Pagado">Pagado</option>
                            </select>
                            <label for="estado">Estado del Pago</label>
                        </div>

                        <div class="input-field col s3">
                            <input type="number" id="miembro_id" name="miembro_id" value='{{$miembro_id}}' class="validate" required hidden>
                        </div>

                        <div class="modal-footer">
                            <button class="btn red" type="submit">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- FIN Modal de nuevo pago -->

        <div class="col s12">
            <!-- <ul class="collapsible popout"> -->
            <ul>
                <li>
                    <!-- <div class="collapsible-header"> -->
                    <div class="card-panel valign-wrapper">
                        <!-- <i class="material-icons">euro_symbol</i> -->
                        <span class="col s1 center"><b>Nº Recibo</b></span>
                        <span class="col s2 "><b>Fecha de vencimiento</b></span>
                        <span class="col s2 "><b>Fecha de pago</b></span>
                        <span class="col s2 "><b>Concepto</b></span>
                        <span class="col s1 right-align"><b>Importe</b></span>
                        <span class="col s1"><b>Estado</b></span>
                        <span class="col s1"><b>Acción</b></span>
                        <span class="col s2 center"><b>Recibo</b></span>

                    </div>
                </li>

            @foreach($pagos as $pago)
                <li>
                    <!-- <div class="collapsible-header"> -->
                    <div class="card-panel valign-wrapper">
                        @if ($pago->estado == 'Pagado')
                            <span class="col s1">{{$pago->nRecibo}}</span>
                        @else
                            <span class="col s1"></span>
                        @endif
                        <span class="col s2">{{!is_null($pago->f_vencimiento) ? date('d-m-Y', strtotime($pago->f_vencimiento)) : ''}}</span>
                        <span class="col s2">{{!is_null($pago->f_pago) ? date('d-m-Y', strtotime($pago->f_pago)) : ''}}</span>
                        <span class="col s2">{{$pago->tipospago->descripcion}}</span>
                        <span class="col s1  right-align">{{$pago->importe}}</span>
                        <span class="col s1">{{$pago->estado}}</span>
                        @if ($pago->estado == 'Pendiente')
                            <span class="col s1"><a href="/pagosMiembro/{{$pago->id}}/pagar" class="btn-small btn-flat waves-effect waves-light tooltipped" data-tooltip="marcar como pagado"><i class="material-icons">check</i></a></span>
                        @elseif ($pago->estado == 'Pagado')
                            <span class="col s1"><a href="/pagosMiembro/{{$pago->id}}/deshacer" class="btn-small btn-flat waves-effect waves-light tooltipped" data-tooltip="marcar como pendiente"><i class="material-icons">undo</i></a></span>
                        @endif

                        @if ($pago->estado == 'Pagado')
                            <span class="col s1 center"><a href="/pdf-reciboPago/{{$pago->id}}/{{$cuota}}/{{$pago->sumPagadoParcial()}}"><i class="material-icons tooltipped" data-tooltip="Imprimir recibo {{$pago->nRecibo}}">print</i></a></span>
                            <span class="col s1 center">
                                @foreach ($miembro->emails as $correo)
                                    <a href="/reciboPago/{{$pago->id}}/{{$cuota}}/{{$pago->sumPagadoParcial()}}/{{$correo->email}}"><i class="material-icons tooltipped" data-tooltip="Enviar recibo a {{$correo->email}}">email</i></a>
                                @endforeach
                            </span>
                        @else
                            <span class="col s2 center"></span>
                        @endif
                    </div>
<!--                     <div class="collapsible-body">
                        @foreach ($miembro->emails as $correo)
                            <span class="flow-text"><a href="/reciboPago/{{$pago->id}}/{{$cuota}}/{{$pago->sumPagadoParcial()}}/{{$correo->email}}">Enviar recibo a {{$correo->email}}</a></br><span>
                        @endforeach
                    </div> -->
                </li>
            @endforeach

            </ul>
        </div>

    </div>


<script>

    $select = document.getElementById("tempSelect").onchange = function(){
        document.getElementById("tempForm").submit();
    };

    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.modal');
        var options = { endingTop : '10%'};
        var instances = M.Modal.init(elems, options);
    });

    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('select');
        var instances = M.FormSelect.init(elems);
    });

    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.tooltipped');
        var instances = M.Tooltip.init(elems);
    });

</script>

@endsection
