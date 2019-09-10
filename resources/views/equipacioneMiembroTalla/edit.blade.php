@extends('layouts.app')

@section('content')

@include('common.errors')

<div class="row">
    <div class="col s10"><h1>{{$miembro->nombre.' '.$miembro->apellido1.' '.$miembro->apellido2}}</h1></div>
    <div class="col s2"><h2>{{$miembro->dorsal}}</h2></div>
</div>

<div class="row section">
    <form method="POST" action="/equipacioneMiembroTalla/{{$miembro->id}}"  class="col s12">
        @method('PUT')
        @csrf

        <div class="input-field col s6">
            <input type="text" name="nomSerigrafia" id="nomSerigrafia" value="{{$miembro->nomSerigrafia}}" class="validate" required>
            <label for="nomSerigrafia">Nombre para la serigrafía:</label>
        </div>

        <table>
            <tbody>
                @foreach($equipaciones as $equipacion)
                    <tr>
                        <td><img src="/images/{{$equipacion->rutaImagen}}" width="50px"></td>
                        <td>{{$equipacion->descripcion}}</td>
                        <td>{{$equipacion->marca}}</td>
                        <td>
                            <select name="tallas[{{$equipacion->id}}]">
                                <option value="" disabled selected>Elije la talla</option>
                                @foreach($equipacion->tallas as $talla)
                                    <option value="{{$talla->id}}" 
                                        @if (!is_null($equipacionesMiembro->find($equipacion->id))) {{ ($talla->id == $equipacionesMiembro->find($equipacion->id)->pivot->talla_id) ? 'selected' : '' }} @endif 
                                    >{{$talla->descripcion}}</option>
                                @endforeach
                            </select>
                            <label>Talla</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="input-field">
                                <input type="date" class="validate" placeholder="" id="f_pruebas[]" name="f_pruebas[{{$equipacion->id}}]" 
                                    @if (!is_null($equipacionesMiembro->find($equipacion->id)))
                                        @if (!is_null($equipacionesMiembro->find($equipacion->id)->pivot->f_prueba))
                                            value="{{date('Y-m-d', strtotime($equipacionesMiembro->find($equipacion->id)->pivot->f_prueba))}}"
                                        @else
                                            value="{{date('Y-m-d')}}"
                                        @endif
                                    @else
                                        value="{{date('Y-m-d')}}"
                                    @endif
                                >
                                <label for="f_pruebas[]">Fecha de prueba:</label>
                            </div>
                        </td>
                        <td>
                            <div class="input-field">
                                <input type="date" class="validate" placeholder="" id="f_pedidos[]" name="f_pedidos[{{$equipacion->id}}]" 
                                    @if (!is_null($equipacionesMiembro->find($equipacion->id)))
                                        @if (!is_null($equipacionesMiembro->find($equipacion->id)->pivot->f_pedido))
                                            value="{{date('Y-m-d', strtotime($equipacionesMiembro->find($equipacion->id)->pivot->f_pedido))}}"
                                        @else
                                            value=""
                                        @endif
                                    @else
                                        value=""
                                    @endif
                                >
                                <label for="f_pedidos[]">Fecha de pedido:</label>
                            </div>
                        </td>
                        <td>
                            <div class="input-field">
                                <input type="date" class="validate" placeholder="" id="f_llegadas[]" name="f_llegadas[{{$equipacion->id}}]" 
                                    @if (!is_null($equipacionesMiembro->find($equipacion->id)))
                                        @if (!is_null($equipacionesMiembro->find($equipacion->id)->pivot->f_llegada))
                                            value="{{date('Y-m-d', strtotime($equipacionesMiembro->find($equipacion->id)->pivot->f_llegada))}}"
                                        @else
                                            value=""
                                        @endif
                                    @else
                                        value=""
                                    @endif
                                >
                                <label for="f_llegadas[]">Fecha de llegada:</label>
                            </div>
                        </td>
                        <td>
                            <div class="input-field">
                                <input type="date" class="validate" placeholder="" id="f_envioseris[]" name="f_envioseris[{{$equipacion->id}}]" 
                                    @if (!is_null($equipacionesMiembro->find($equipacion->id)))
                                        @if (!is_null($equipacionesMiembro->find($equipacion->id)->pivot->f_envioseri))
                                            value="{{date('Y-m-d', strtotime($equipacionesMiembro->find($equipacion->id)->pivot->f_envioseri))}}"
                                        @else
                                            value=""
                                        @endif
                                    @else
                                        value=""
                                    @endif
                                >
                                <label for="f_envioseris[]">Fecha de envío a serigrafía:</label>
                            </div>
                        </td>
                        <td>
                            <div class="input-field">
                                <input type="date" class="validate" placeholder="" id="f_llegadaseris[]" name="f_llegadaseris[{{$equipacion->id}}]" 
                                    @if (!is_null($equipacionesMiembro->find($equipacion->id)))
                                        @if (!is_null($equipacionesMiembro->find($equipacion->id)->pivot->f_llegadaseri))
                                            value="{{date('Y-m-d', strtotime($equipacionesMiembro->find($equipacion->id)->pivot->f_llegadaseri))}}"
                                        @else
                                            value=""
                                        @endif
                                    @else
                                        value=""
                                    @endif
                                >
                                <label for="f_llegadaseris[]">Fecha de llegada de serigrafía:</label>
                            </div>
                        </td>
                        <td>
                            <div class="input-field">
                                <input type="date" class="validate" placeholder="" id="f_entregas[]" name="f_entregas[{{$equipacion->id}}]" 
                                    @if (!is_null($equipacionesMiembro->find($equipacion->id)))
                                        @if (!is_null($equipacionesMiembro->find($equipacion->id)->pivot->f_entrega))
                                            value="{{date('Y-m-d', strtotime($equipacionesMiembro->find($equipacion->id)->pivot->f_entrega))}}"
                                        @else
                                            value=""
                                        @endif
                                    @else
                                        value=""
                                    @endif
                                >
                                <label for="f_entregas[]">Fecha de entrega:</label>
                            </div>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="col s12">
            <button class="waves-effect waves-red btn" type="submit">Guardar</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('select');
        var instances = M.FormSelect.init(elems);
    });
</script>

@endsection
