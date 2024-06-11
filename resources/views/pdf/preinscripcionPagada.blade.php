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
    .textomini {
        font-size: 7pt;
    }
    .texto {
        font-size: 7pt;
        text-align: center;
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
        font-size: 11pt;
    }

    .textoFecha {
        font-size: 11pt;
        text-align: center;
    }

    .textoNombre {
        font-size: 9pt;
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
                <span class="cabecera">IMPORTE DEL PAGO:</span> <b>{{$preinscripcion->importePago}}</b> euros<br>
                <i>A DESCONTAR DE LA CUOTA ANUAL</i>
            </td>
            <td colspan="6">
                <b>Por la presente entrego la cantidad de {{$preinscripcion->importePago}} euros</b>
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

    <!-- <div class="page-break"></div>

     <p align="justify" class="textomini">El tallaje de la ropa y su pago, según las instrucciones contenidas en el mail que emitía este documento y la factura de inscripción, se realizará en la tienda de Justo Muñoz en el CC Rio Shopping de Arroyo de la Encomienda, desde el 1 de julio y hasta el 31 de octubre de 2023, salvo situación excepcional. Debe acudir a la tienda de Justo Muñoz con este documento, anotando previamente el número de dorsal y el nombre de la camiseta, lo que se proporcionará en la oficina del Club Balonmano Laguna.</p>
    <hr/>

    <table width="100%"  class="textoRopa">
        <tr>
            <td colspan="6">
                <table width="100%" class="tabla">
                    <tr>
                        <td colspan="2">
                            <img src="images/escudo.png" width="50px">
                        </td>
                        <td colspan="10" class="textoNombre">
                            <span>Nombre:</span> <b>{{$preinscripcion->nombre.' '.$preinscripcion->apellido1.' '.$preinscripcion->apellido2}}</b>
                            <br/>
                            <span>Dorsal:</span> <b>_____</b>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="10" class="negrita">Ropa</th>
                        <th colspan="2" class="negrita">Talla</th>
                    </tr>

                    <tr>
                        <td colspan="10">Camiseta Negra</td>
                        <td colspan="2">_____</td>
                    </tr>
                    <tr>
                        <td colspan="10">Camiseta Roja</td>
                        <td colspan="2">_____</td>
                    </tr>
                    <tr>
                        <td colspan="10">Pantalón corto</td>
                        <td colspan="2">_____</td>
                    </tr>
                    <tr>
                        <td colspan="10">Chaqueta Chándal</td>
                        <td colspan="2">_____</td>
                    </tr>
                    <tr>
                        <td colspan="10">Pantalón Chándal</td>
                        <td colspan="2">_____</td>
                    </tr>
                    <tr>
                        <td colspan="10">Cazadora</td>
                        <td colspan="2">_____</td>
                    </tr>
                    <tr>
                        <td colspan="10">Otros (________________)</td>
                        <td colspan="2">_____</td>
                    </tr>
                    <tr>
                        <td colspan="12" class="textoFecha"><br/></td>

                    </tr>
                    <tr>
                        <td colspan="12" class="textoFecha">Fecha de prueba:</td>

                    </tr>
                    <tr>
                        <td colspan="12" class="textoFecha">_________________</td>
                    </tr>
                    <tr>
                        <td colspan="12" class="textoFecha"><br/></td>
                    </tr>

                    <tr>
                        <td colspan="12" class="textoFecha">Ejemplar para el jugador</td>
                    </tr>
                </table>
            </td>
            <td colspan="6">
                <table width="100%" class="tabla">
                    <tr>
                        <td colspan="2">
                            <img src="images/escudo.png" width="50px">
                        </td>
                        <td colspan="10" class="textoNombre">
                            <span>Nombre:</span> <b>{{$preinscripcion->nombre.' '.$preinscripcion->apellido1.' '.$preinscripcion->apellido2}}</b>
                            <br/>
                            <span>Dorsal:</span> <b>_____</b>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="10" class="negrita">Ropa</th>
                        <th colspan="2" class="negrita">Talla</th>
                    </tr>

                    <tr>
                        <td colspan="10">Camiseta Roja</td>
                        <td colspan="2">_____</td>
                    </tr>
                    <tr>
                        <td colspan="10">Camiseta Negra</td>
                        <td colspan="2">_____</td>
                    </tr>
                    <tr>
                        <td colspan="10">Pantalón corto</td>
                        <td colspan="2">_____</td>
                    </tr>
                    <tr>
                        <td colspan="10">Chaqueta Chándal</td>
                        <td colspan="2">_____</td>
                    </tr>
                    <tr>
                        <td colspan="10">Pantalón Chándal</td>
                        <td colspan="2">_____</td>
                    </tr>
                    <tr>
                        <td colspan="10">Cazadora</td>
                        <td colspan="2">_____</td>
                    </tr>
                    <tr>
                        <td colspan="10">Otros (________________)</td>
                        <td colspan="2">_____</td>
                    </tr>

                    <tr>
                        <td colspan="12" class="textoFecha"><br/></td>
                    </tr>
                    <tr>
                        <td colspan="12" class="textoFecha">Fecha de prueba:</td>

                    </tr>
                    <tr>
                        <td colspan="12" class="textoFecha">_________________</td>
                    </tr>
                    <tr>
                        <td colspan="12" class="textoFecha"><br/></td>
                    </tr>

                    <tr>
                        <td colspan="12" class="textoFecha">Ejemplar para la tienda</td>
                    </tr>

                </table>
            </td>

        </tr>
    </table>
    <DIV STYLE="position:absolute; top:350px; left:255px; visibility:visible z-index:-1">
        <IMG SRC="images/sello.jpg" width="180">
    </div> -->
</body>
</html>
