<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Preinscripción</title>
</head>
<style>
    @page {margin-bottom:0px}

    body {  font-family: DejaVu Sans;
            font-size:12pt  }
    
    p { margin-top: 5px;
        margin-bottom: 5px    }

    hr { border-style: dashed;
         noshade: noshade
    }
    .cabecera {
        font-size: 10pt;
    }
    .texto {
        font-size: 7pt;
        text-align: left;
    }
    .page-break {
        page-break-after: always;
    }
    .tabla {
        border: 1px solid black;
        border-collapse: collapse;
    }
    .borde {
        border: 1px dashed black;
    }
    .negrita {
        font-weight: bold;
    }

    hr { border-style: dashed;
         noshade: noshade
    }

    .textoRopa {
        font-size: 13pt;
    }

    .textoFecha {
        font-size: 13pt;
        text-align: center;
    }

    .textoNombre {
        font-size: 9pt;
    }

    .espaciado {
        height: 150pt;
    }

</style>
<body>
    <table width="100%">
        <tbody>
            <tr>
                <td>
                    <img src="images/escudo.png" width="100px">
                </td>
                <td colspan="6">
                    <h3>CLUB BALONMANO LAGUNA</h3>
                </td>
                <td colspan="5">
                    <span class="cabecera">Nº RECIBO:</span> <b>{{$pago->nRecibo}}</b><br>
                    <span class="cabecera">Fecha:</span> <b>{{date('d-m-Y', strtotime($pago->f_pago))}}</b>
                </td>
                
            </tr>

            <tr>
                <td colspan="12">
                    <span class="cabecera">Recibí de </span> <b>{{$miembro->nombre.' '.$miembro->apellido1.' '.$miembro->apellido2}}</b>
                    <span class= "cabecera"> con documento nº </span> <b>{{$miembro->nif}}</b>
                </td>
            </tr>
            <tr>
                <td colspan="12">
                    <span>la cantidad de </span> <b>{{$pago->importe}} euros</b>
                </td>
            </tr>
            <tr>
                <td colspan="12">
                    <span>en concepto de</span> 
                    <b>
                        @if ($pago->tipospago->descripcion =="Inscripción") 
                            @if (($cuota - $pagado) <= 0)
                            <span>resto de la</span>
                            @else
                            <span>parte de la</span>
                            @endif
                        @endif
                        <span>{{$pago->tipospago->descripcion}} temporada {{$pago->temporada->descripcion}}</span>
                    </b>
                </td>
            </tr>
            <tr>
                <td colspan="12">
                    <p class="texto"><b>RECIBO JUSTIFICANTE DE PAGO PARA EL INTERESADO</b></p>
                </td>
            </tr>
            
            <tr>
                <td colspan="3"></td>
                <td colspan="6">
                    <img src="images/sello.jpg" width="150px">
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="12" class="texto espaciado">
                    <span>A título informativo:</span><br>
                    <span>Cuota temporada {{$pago->temporada->descripcion}} <b>{{$cuota}}</b> euros. Pagado hasta ahora <b>{{$pagado}}</b>. Resto a pagar <b>{{$cuota-$pagado}}</b></span>
                </td>
            </tr>
        </tfoot>
    </table>
</body>
</html>