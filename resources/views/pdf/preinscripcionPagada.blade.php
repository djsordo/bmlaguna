<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Preinscripción</title>
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

</style>
<body>
    <table width="100%">
        <tr>
            <td>
                <img src="images/escudo.png" width="100px">
            </td>
            <td colspan="6">
                <h3>CLUB BALONMANO LAGUNA</h3>
            </td>
            <td colspan="5">
                <span class="cabecera">Nº RECIBO:</span> <b>{{$preinscripcion->nRecibo}}</b><br>
                <span class="cabecera">Fecha:</span> <b>{{date('d-m-Y', strtotime($preinscripcion->f_pago))}}</b>
            </td>
            
        </tr>

        <tr>
            <td colspan="12">
                <span class="cabecera">N.I.F:</span> <b>{{$preinscripcion->nif}}</b>
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <span class="cabecera">Nombre del jugador:</span> <b>{{$preinscripcion->nombre.' '.$preinscripcion->apellido1.' '.$preinscripcion->apellido2}}</b>
            </td>
            <td colspan="6">
                <span class="cabecera">Fecha de Nacimiento:</span> <b>{{date('d-m-Y', strtotime($preinscripcion->f_nacimiento) )}}</b>
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <span class="cabecera">Nombre del responsable:</span> <b>{{$preinscripcion->nombreR1.' '.$preinscripcion->apellido1R1.' '.$preinscripcion->apellido2R1}}</b>
            </td>
            
            <td colspan="6">
                <span class="cabecera">Nombre del responsable:</span> <b>{{$preinscripcion->nombreR2.' '.$preinscripcion->apellido1R2.' '.$preinscripcion->apellido2R2}}</b>
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <span class="cabecera">Teléfono de contacto:</span><b>{{$preinscripcion->telefono}}</b>
            </td>
            <td colspan="6">
                <span class="cabecera">eMail:</span><b>{{$preinscripcion->email}}</b>
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <span class="cabecera">Dirección:</span> <b>{{$preinscripcion->domicilio}}</b>
            </td>
            <td colspan="6">
                <span class="cabecera">Código Postal:</span> <b>{{$preinscripcion->c_postal}}</b>
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <span class="cabecera">Localidad:</span> <b>{{$preinscripcion->localidad}}</b>
            </td>
            <td colspan="6">
                <span class="cabecera">Provincia:</span> <b>{{$preinscripcion->provincia}}</b>
            </td>
        </tr>
         <tr>
            <td colspan="6">
                <span class="cabecera">IMPORTE DE LA PREINSCRIPCIÓN:</span> <b>100 euros</b><br>
                <i>A DESCONTAR DE LA CUOTA ANUAL</i>
            </td>
            <td colspan="6">
                <b>Por la presente entrego la cantidad de 100 euros</b>
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
    </table>
</body>
</html>