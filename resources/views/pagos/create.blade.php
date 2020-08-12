@extends('layouts.app')

@section('content')
@include('common.errors')


    <div class="section row">
        <div class="col s12">
            <h2 class="center">Pagos de {{$miembro->nombre.' '.$miembro->apellido1.' '.$miembro->apellido2}}</h2>
        </div>

        <form method="POST" action="/pagos" class="col s12">
            @csrf
            <div class="row card-panel">

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
                    <input type="text" class="datepicker validate" id="f_pago" name="f_pago" value="{{ date('d-m-Y') }}">
                    <label for="f_pago">Fecha de pago:</label>
                </div>

                <div class="input-field col s4">
                    <select name="tipospago_id" id="tipospago">
                        <option value="" disabled selected>Elige una</option>
                        @foreach ($tipospagos as $tipospago)
                            <option value="{{ $tipospago->id }}">{{ $tipospago->descripcion }}</option>
                        @endforeach
                    </select>
                    <label for="tipospago">Tipo de Pago</label>
                </div>

                <div class="input-field col s3">
                    <input type="number" placeholder="Importe" id="importe" name="importe" class="validate" required>
                    <label for="importe">Importe del pago:</label>
                </div>

                <div class="input-field col s3">
                    <input type="number" id="miembro_id" name="miembro_id" value='{{$miembro_id}}' class="validate" required hidden>
                    
                </div>

                <button class="btn red" type="submit">Guardar</button>
            </div>        
        </form>

        {{-- <h1>{{$cuota}}</h1> --}}
        {{-- Lista de pagos hechos por el miembro --}}
        <h4>Pagos de la temporada actual</h4>
        <table class="striped">
            <thead> 
                <tr>
                    <th>Temporada</th>
                    <th>Fecha de pago</th>
                    <th>Concepto</th>
                    <th>Importe</th>
                </tr>
            </thead>
        
            <tbody>
                @foreach($pagos as $pago)
                    <tr>
                        <td>{{$pago->temporada->descripcion}}</td>
                        <td>{{$pago->f_pago}}</td>
                        <td>{{$pago->tipospago->descripcion}}</td>
                        <td>{{$pago->importe}}</td>
                    </tr>
                @endForeach
            </tbody>
        </table>
       
    </div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('select');
        var instances = M.FormSelect.init(elems);
    });
</script>

@endsection