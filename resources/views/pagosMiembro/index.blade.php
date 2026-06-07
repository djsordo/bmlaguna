@extends('layouts.app')

@section('content')
@include('common.success')
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
                        <div class="input-field col s2">
                            <select name="temporada_id" id="temporada">
                                <option value="" disabled selected>Elige una</option>
                                @foreach ($temporadas as $temporada)
                                    <option value="{{ $temporada->id }}" {{ ($temporada == $tempAct) ? 'selected' : '' }}>{{ $temporada->descripcion}}</option>
                                @endforeach
                            </select>
                        <label for="temporada">Temporada:</label>
                        </div>

                        <div class="input-field col s3">
                            <input type="text" class="datepicker datepicker-en-modal validate" id="f_pago" name="f_pago" value="{{ date('d-m-Y') }}">
                            <label for="f_pago">Fecha de pago:</label>
                        </div>

                        <div class="input-field col s4">
                            <select name="tipospago_id" id="tipospago">
                                <option value="" disabled selected>Elige una</option>
                                @foreach ($tipospagos as $tipospago)
                                    <option value="{{ $tipospago->id }}" {{($tipospago->descripcion == 'Inscripción') ? 'selected' : '' }} >{{ $tipospago->descripcion }}</option>
                                @endforeach
                            </select>
                            <label for="tipospago">Tipo de Pago</label>
                        </div>

                        <div class="input-field col s3">
                            <input type="number" placeholder="Importe" id="importe" name="importe" class="validate" value="{{$cuota - $pagado}}" step=".01" required>
                            <label for="importe">Importe del pago:</label>
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

        <!-- Modal: registrar fecha de pago (pago pendiente) -->
        <div id="marcarPagoModal" class="modal modal-marcar-pago">
            <div class="modal-content">
                <h4>Registrar fecha de pago</h4>
                <div class="row">
                    <form id="marcarPagoForm" method="POST" action="#">
                        @csrf
                        @method('PUT')
                        <div class="input-field col s12">
                            <input type="text" class="datepicker datepicker-en-modal validate" id="marcarPagoFecha" name="f_pago" value="{{ date('d-m-Y') }}">
                            <label for="marcarPagoFecha">Fecha de pago</label>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn red waves-effect waves-light" type="submit" form="marcarPagoForm">Guardar</button>
                <a href="#!" class="btn-flat modal-close waves-effect">Cancelar</a>
            </div>
        </div>
        <!-- FIN modal marcar pago -->

        <div class="col s12">
            <ul class="collapsible popout">
                <li>
                    <div class="collapsible-header">
                        <i class="material-icons">euro_symbol</i>
                        <span class="col s3"><b>Fecha de pago</b></span>
                        <span class="col s3"><b>Concepto</b></span>
                        <span class="col s2"><b>Vencimiento</b></span>
                        <span class="col s2 right-align"><b>Importe</b></span>
                        <span class="col s1 center"><b>Recibo</b></span>
                        <span class="col s1 center"><b>Cobrar</b></span>
                    </div>
                </li>

            @foreach($pagos as $pago)
                <li>
                    <div class="collapsible-header">
                        @if($pago->esRealizado())
                            <i class="material-icons tooltipped" data-tooltip="Enviar correo electrónico con el recibo">email</i>
                        @else
                            <i class="material-icons grey-text text-lighten-1 tooltipped" data-tooltip="Sin fecha de pago (pendiente)">email</i>
                        @endif
                        <span class="col s3">
                            @if($pago->esRealizado())
                                {{ date('d-m-Y', strtotime($pago->f_pago)) }}
                            @else
                                <span class="grey-text">Pendiente</span>
                            @endif
                        </span>
                        <span class="col s3">{{$pago->tipospago->descripcion}}</span>
                        <span class="col s2">
                            @if($pago->f_vencimiento)
                                {{ date('d-m-Y', strtotime($pago->f_vencimiento)) }}
                            @else
                                <span class="grey-text">—</span>
                            @endif
                        </span>
                        <span class="col s2  right-align">{{$pago->importe}}</span>
                        <span class="col s1 center">
                            @if($pago->esRealizado())
                                <a href="/pdf-reciboPago/{{$pago->id}}/{{$cuota}}/{{$pago->sumPagadoParcial()}}"><i class="material-icons tooltipped" data-tooltip="Imprimir recibo {{$pago->nRecibo}}">print</i></a>
                            @else
                                <i class="material-icons grey-text text-lighten-1 tooltipped" data-tooltip="Recibo disponible cuando exista fecha de pago">print</i>
                            @endif
                        </span>
                        <span class="col s1 center">
                            @if(!$pago->esRealizado())
                                <a href="#marcarPagoModal"
                                   class="modal-trigger js-marcar-pago tooltipped"
                                   data-tooltip="Registrar fecha de pago"
                                   data-action="{{ route('pagosMiembro.update', $pago->id) }}">
                                    <i class="material-icons green-text text-darken-2">done</i>
                                </a>
                            @else
                                <span class="grey-text">—</span>
                            @endif
                        </span>
                    </div>
                    <div class="collapsible-body">
                        @if($pago->esRealizado())
                            @foreach ($miembro->emails as $correo)
                                <span class="flow-text"><a href="/reciboPago/{{$pago->id}}/{{$cuota}}/{{$pago->sumPagadoParcial()}}/{{$correo->email}}">Enviar recibo a {{$correo->email}}</a></br><span>
                            @endforeach
                        @else
                            <span class="flow-text grey-text">El recibo por correo estará disponible cuando se registre la fecha de pago.</span>
                        @endif
                    </div>
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

    document.addEventListener('DOMContentLoaded', function() {
        var i18n = {
            months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
            monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
            weekdays: ["Domingo","Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
            weekdaysShort: ["Dom","Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
            weekdaysAbbrev: ["D","L", "M", "M", "J", "V", "S"]
        };
        var baseOpts = {
            firstDay: 1,
            showClearBtn: true,
            showMonthAfterYear: true,
            format: 'dd-mm-yyyy',
            yearRange: 50,
            i18n: i18n
        };
        /* Fuera del modal: el calendario se coloca junto al input (comportamiento por defecto). */
        M.Datepicker.init(document.querySelectorAll('.datepicker:not(.datepicker-en-modal)'), baseOpts);
        /* Dentro de modales: el calendario va al body para no quedar recortado por overflow del modal. */
        M.Datepicker.init(document.querySelectorAll('.datepicker-en-modal'), Object.assign({}, baseOpts, {
            container: document.body
        }));
    });

    document.addEventListener('DOMContentLoaded', function() {
        function hoyDDMMAAAA() {
            var d = new Date();
            var dd = ('0' + d.getDate()).slice(-2);
            var mm = ('0' + (d.getMonth() + 1)).slice(-2);
            return dd + '-' + mm + '-' + d.getFullYear();
        }
        document.querySelectorAll('.js-marcar-pago').forEach(function (a) {
            a.addEventListener('click', function () {
                var action = a.getAttribute('data-action');
                var f = document.getElementById('marcarPagoForm');
                if (action && f) {
                    f.setAttribute('action', action);
                }
                var inp = document.getElementById('marcarPagoFecha');
                if (inp) {
                    inp.value = hoyDDMMAAAA();
                    if (typeof M !== 'undefined' && M.updateTextFields) {
                        M.updateTextFields();
                    }
                }
            });
        });
    });

</script>

@endsection
