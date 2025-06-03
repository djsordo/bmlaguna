<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cuotas temporada {{$temporada->descripcion}}</title>
</head>
<style>
    body {  font-family: DejaVu Sans;
            font-size:9pt  }

    .centrar {
        text-align: center }

    /* p { margin-top: 5px;
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

*/

</style>
<body>
    <table width="100%" border="0" cellspacing="0" cellpadding="100%">
        <th>
            <td colspan="2"><img src="images/escudo.png" width="50px"></td>
            <td colspan="10">
                <h1>CLUB BALONMANO LAGUNA</h1>
                <h2>Cuotas para la temporada {{$temporada->descripcion}}</h2>
            </td>
        </th>
    </table>

    <p>
    Esta es la tabla de cuotas para la temporada 23-24:
    </p>
    <table width="100%">
        <tr>
            <th colspan="2">Categoría</th>
            <th colspan="2">Nacimiento</th>
            <th colspan="2">Precio</th>
            <th colspan="2">Modalidad:<br>3 recibos</th>
            <th colspan="2">Modalidad:<br>2 recibos</th>
            <th colspan="2">Modalidad:<br>1 recibo</th>
        </tr>

        @foreach ($categorias as $categoria)
            <tr>
                <td colspan="2"><b>{{$categoria->descripcion}}</b></td>
                <td colspan="2">{{$categoria->rangoannos($temporada)[0]}} - {{$categoria->rangoannos($temporada)[1]}}</td>
                <td colspan="2">{{$categoria->precio_inscripcion}}</td>
                <td colspan="2">{{$categoria->precio_3c1}}+{{$categoria->precio_3c2}}+{{$categoria->precio_3c3}}</td>
                <td colspan="2">{{$categoria->precio_2c1}}+{{$categoria->precio_2c2}}</td>
                <td colspan="2">{{$categoria->precio_inscripcion}}</td>
            </tr>
        @endforeach

    </table>

    <p>
        Ponemos en marcha varias <b>modalidades de pago</b>, <u>para la inscripción directa en el club</u>:
    </p>
    <ul>
        <li>
            <b>Pago en 3 recibos.</b> Solo para los que se inscriban hasta el 15 de julio de 2024. Los pagos se realizarán de la siguiente forma:
            <ul>
                <li><b>Primer pago</b>, a continuación de la inscripción, y con fecha máxima el <b>15 de julio de 2024</b>.</li>
                <li><b>Segundo pago</b>, con fecha máxima el <b>15 de octubre de 2025</b>.</li>
                <li><b>Tercer pago</b>, con fecha máxima el <b>15 de enero de 2025</b>.</li>
            </ul>
        </li>
        <li>
            <b>Pago en 2 recibos.</b> Los pagos se realizarán de la siguiente forma:
            <ul>
                <li><b>Primer pago</b>, a continuación de la inscripción.</li>
                <li><b>Segundo pago</b>, con fecha máxima el <b>15 de enero de 2025</b>.</li>
            </ul>
        </li>
        <li>
            <b>Pago en 1 recibo</b>. A continuación de la inscripción.
        </li>
    </ul>
    <p>
        Las <b>formas de pago</b> de los recibos:
    </p>
    <ol>
        <li><b>Presencialmente</b> en la oficina del Club, pudiéndose realizar tanto en metálico como con tarjeta bancaria.</li>
        <li>A través de <b>transferencia bancaria</b> a la cuenta de la Caixa a nombre del Club Deportivo Balonmano Laguna, con número IBAN: ES33 2100 4332 5801 0024 1501, poniendo en el concepto de la transferencia el nombre del jugador.</li>
    </ol>
    <p>
        Los <b>pagos de los recibos se deben realizar convenientemente y en su fecha</b>. De no ser así, se procederá al bloqueo de la ficha federativa del jugador hasta que se solucione el problema.
    </p>
    <p>
        Todo aquel que lo desee podrá adelantar el pago de los recibos.
    </p>
    <p>
        Para poder solventar cualquier situación especial o incidencia con respecto al pago de la cuota, contactar con el Club por correo a la dirección bmnlaguna@gmail.com, o personalmente en la oficina.
    </p>
    <p>
        <b>La oficina se sitúa</b> en el Polideportivo Municipal de Laguna de Duero (Avd de las Salinas nº3), y abre los miércoles y viernes de 19 a 21 horas.
    </p>
    <p>
        La equipación de juego se compra aparte, realizando el pedido en la oficina del club, y hasta el 31 de octubre de 2025. La ropa que se quiera comprar a partir de esa fecha, se realizará en la tienda web de New Balance Bm Laguna. Se recibirán instrucciones al respecto en el mail que se envía a los padres junto con el primer justificante de pago del precio de la actividad.
    </p>
</body>
</html>
