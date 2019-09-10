<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Equipación</title>
</head>
<style>
    body {  font-family: DejaVu Sans;
            font-size:9pt  }
    
    p { margin-top: 5px;
        margin-bottom: 5px    }

    hr { border-style: dashed;
         noshade: noshade
    }
    .cabecera {
        font-size: 7pt;
    }
    .texto {
        font-size: 7pt;
        text-align: center;
    }
    .tabla {
        border: 1px solid black;
        border-collapse: collapse;
    }
    .centrar {
        text-align: center;
    }

</style>
<body>
    <table width="100%">
        <tr>
            <td>
                <img src="images/escudo.png" width="50px">
            </td>
            <td colspan="6">
                <h3>CLUB BALONMANO LAGUNA</h3>
            </td>

            
        </tr>

        <tr>
            <td colspan="6">
                <span class="cabecera">Nombre del jugador:</span> <b>{{$miembro->nombre.' '.$miembro->apellido1.' '.$miembro->apellido2}}</b>
            </td>
            <td colspan="6">
                <span class="cabecera">Fecha de Nacimiento:</span> <b>{{date('d-m-Y', strtotime($miembro->f_nacimiento) )}}</b>
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <span class="cabecera">Nombre Serigrafía:</span> <b>{{$miembro->nomSerigrafia}}</b>
            </td>
            <td colspan="6">
                <span class="cabecera">Dorsal:</span> <b>{{$miembro->dorsal}}</b>
            </td>
        </tr>
        <tr>
            <td colspan="12">
            <table width="100%" class="tabla">
                <thead class="tabla">
                    <tr>
                        <th>Prenda</th>
                        <th class="centrar">Talla</th>
                        <th class="centrar">Fecha de Prueba</th>
                        <th class="centrar">Fecha de entrega</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($miembro->equipaciones()->get() as $equipacion)
                        <tr>
                            <td>{{$equipacion->descripcion}}</td>
                            <td class="centrar">{{$equipacion->tallas()->find($equipacion->pivot->talla_id)->descripcion}}</td>
                            <td class="centrar">@if (isset($equipacion->pivot->f_prueba))
                                    {{date('d-m-Y', strtotime($equipacion->pivot->f_prueba))}}
                                @endif
                            </td>
                            <td class="centrar">@if (isset($equipacion->pivot->f_entrega))
                                    {{date('d-m-Y', strtotime($equipacion->pivot->f_entrega))}}
                                @endif
                            </td>
                        </tr>
                    @endforeach
        
                </tbody>
            </table>
            </td>
        </tr>
        <tr>
            <td colspan="12">
                <p class="texto"><b>RECIBO JUSTIFICANTE PARA EL CLUB</b><br>
                El presente documento no tiene validez sin el sello y firma autorizada</p>
            </td>
        </tr>
       
        <tr>
            <td colspan="6">
                <p class="texto">Declaro que los datos arriba indicados son correctos<br>
                Firma<br><br></p>
                
            </td>
            <td colspan="6" rowspan="6">
                <p class="texto">
                    <br>
                    <br>
                    La Junta Directiva</p>
            </td>
        </tr>
    </table>
    <hr />
    <table width="100%">
        <tr>
            <td>
                <img src="images/escudo.png" width="50px">
            </td>
            <td colspan="6">
                <h3>CLUB BALONMANO LAGUNA</h3>
            </td>

            
        </tr>

        <tr>
            <td colspan="6">
                <span class="cabecera">Nombre del jugador:</span> <b>{{$miembro->nombre.' '.$miembro->apellido1.' '.$miembro->apellido2}}</b>
            </td>
            <td colspan="6">
                <span class="cabecera">Fecha de Nacimiento:</span> <b>{{date('d-m-Y', strtotime($miembro->f_nacimiento) )}}</b>
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <span class="cabecera">Nombre Serigrafía:</span> <b>{{$miembro->nomSerigrafia}}</b>
            </td>
            <td colspan="6">
                <span class="cabecera">Dorsal:</span> <b>{{$miembro->dorsal}}</b>
            </td>
        </tr>
        <tr>
            <td colspan="12">
            <table width="100%" class="tabla">
                <thead class="tabla">
                    <tr>
                        <th>Prenda</th>
                        <th class="centrar">Talla</th>
                        <th class="centrar">Fecha de Prueba</th>
                        <th class="centrar">Fecha de entrega</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($miembro->equipaciones()->get() as $equipacion)
                        <tr>
                            <td>{{$equipacion->descripcion}}</td>
                            <td class="centrar">{{$equipacion->tallas()->find($equipacion->pivot->talla_id)->descripcion}}</td>
                            <td class="centrar">@if (isset($equipacion->pivot->f_prueba))
                                    {{date('d-m-Y', strtotime($equipacion->pivot->f_prueba))}}
                                @endif
                            </td>
                            <td class="centrar">@if (isset($equipacion->pivot->f_entrega))
                                    {{date('d-m-Y', strtotime($equipacion->pivot->f_entrega))}}
                                @endif
                            </td>
                        </tr>
                    @endforeach
        
                </tbody>
            </table>
            </td>
        </tr>
        <tr>
            <td colspan="12">
                <p class="texto"><b>RECIBO JUSTIFICANTE PARA EL INTERESADO</b><br>
                El presente documento no tiene validez sin el sello y firma autorizada</p>
            </td>
        </tr>
        
        <tr>
            <td colspan="6">
                <p class="texto">Declaro que los datos arriba indicados son correctos<br>
                Firma<br><br></p>
                
            </td>
            <td colspan="6" rowspan="6">
                <p class="texto">
                    <br>
                    <br>
                    La Junta Directiva</p>
            </td>
        </tr>
    </table>
</body>
</html>