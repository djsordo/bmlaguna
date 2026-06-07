<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cuotas temporada {{ $temporada->descripcion }}</title>
</head>
<style>
    @page {
        margin: 0.75cm 2.5cm 1.5cm 2.5cm;
    }
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 8.5pt;
        line-height: 1.15;
        margin: 0;
        padding: 0.15cm 0.2cm 0.2cm 0.2cm;
    }
    .centrar { text-align: center; }
    .cabecera-pdf {
        text-align: center;
        padding-bottom: 10px;
        margin-bottom: 10px;
        border-bottom: 1px solid #333;
    }
    .cabecera-pdf__marca {
        margin: 0 auto 4px auto;
        border-collapse: collapse;
    }
    .cabecera-pdf__marca td {
        vertical-align: middle;
        padding: 0 6px;
    }
    .cabecera-pdf h1 {
        font-size: 14pt;
        margin: 0;
        text-align: left;
    }
    .cabecera-pdf h2 {
        font-size: 11pt;
        margin: 0;
        font-weight: normal;
    }
    h1 { font-size: 14pt; margin: 0 0 4px 0; }
    h2 { font-size: 11pt; margin: 0; font-weight: normal; }
    p { text-align: justify; margin: 4px 0; }
    ul, ol { margin: 3px 0; padding-left: 18px; }
    li { margin-bottom: 2px; line-height: 1.15; }
    table.cuotas {
        width: 100%;
        border-collapse: collapse;
        margin: 8px 0;
        font-size: 7.5pt;
        line-height: 1.1;
    }
    table.cuotas th,
    table.cuotas td {
        border: 1px solid #000;
        padding: 3px 2px;
        text-align: center;
        vertical-align: middle;
    }
    table.cuotas th {
        font-weight: bold;
        background-color: #f5f5f5;
        text-transform: uppercase;
        font-size: 7pt;
        letter-spacing: 0.02em;
    }
    table.cuotas td.cat { text-align: left; font-weight: bold; }
</style>
<body>
    @php
        $ref = $categorias->first();
        $fechaPlazo3c1 = $ref ? \BMLaguna\Categoria::formatearPlazo($ref->f_plazo_3c1) : null;
        $fechaPlazo3c2 = $ref ? \BMLaguna\Categoria::formatearPlazo($ref->f_plazo_3c2) : null;
        $fechaPlazo3c3 = $ref ? \BMLaguna\Categoria::formatearPlazo($ref->f_plazo_3c3) : null;
        $fechaPlazo2c2 = $ref ? \BMLaguna\Categoria::formatearPlazo($ref->f_plazo_2c2) : null;
        $fechaPlazoInsc = $ref ? \BMLaguna\Categoria::formatearPlazo($ref->f_plazo_insc) : null;
        $fechaPlazo3c1 = $fechaPlazo3c1 ?: '15 de julio de 2026';
        $fechaPlazo3c2 = $fechaPlazo3c2 ?: '15 de octubre de 2026';
        $fechaPlazo3c3 = $fechaPlazo3c3 ?: '15 de enero de 2027';
        $fechaPlazo2c2 = $fechaPlazo2c2 ?: '15 de enero de 2027';
        $fechaPlazoInsc = $fechaPlazoInsc ?: '15 de julio de 2026';
    @endphp

    <header class="cabecera-pdf">
        <table class="cabecera-pdf__marca" align="center">
            <tr>
                <td><img src="images/escudo.png" width="58" alt=""></td>
                <td><h1>CLUB BALONMANO LAGUNA</h1></td>
            </tr>
        </table>
        <h2>CUOTAS PARA LA TEMPORADA {{ strtoupper($temporada->descripcion) }}</h2>
    </header>

    <p>Esta es la tabla de cuotas para la temporada {{ $temporada->descripcion }}:</p>

    <table class="cuotas">
        <thead>
            <tr>
                <th style="width: 16%;">CATEGORÍA</th>
                <th style="width: 12%;">NACIMIENTO</th>
                <th style="width: 9%;">PRECIO</th>
                <th style="width: 18%;">MODALIDAD<br>3 RECIBOS</th>
                <th style="width: 15%;">MODALIDAD<br>2 RECIBOS</th>
                <th style="width: 12%;">MODALIDAD<br>1 RECIBO</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categorias as $categoria)
                @php
                    $rango = $categoria->rangoAnnos($temporada);
                @endphp
                <tr>
                    <td class="cat">{{ $categoria->descripcion }}</td>
                    <td>{{ $rango[0] }} – {{ $rango[1] }}</td>
                    <td>{{ $categoria->precio_inscripcion3c }}</td>
                    <td>{{ $categoria->cuotaTresRecibosTexto() }}</td>
                    <td>{{ $categoria->cuotaDosRecibosTexto() }}</td>
                    <td>{{ $categoria->precio_inscripcion }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p>Ponemos en marcha varias modalidades de pago, para la inscripción en el Club:</p>
    <ul>
        <li><strong>Pago en 3 recibos.</strong> Solo para los que se inscriban hasta el {{ $fechaPlazoInsc }}. Los pagos se realizarán de la siguiente forma:
            <ul>
                <li>Primer pago, a continuación de la inscripción, y con fecha máxima el {{ $fechaPlazo3c1 }}.</li>
                <li>Segundo pago, con fecha máxima el {{ $fechaPlazo3c2 }}.</li>
                <li>Tercer pago, con fecha máxima el {{ $fechaPlazo3c3 }}.</li>
            </ul>
        </li>
        <li><strong>Pago en 2 recibos.</strong> Los pagos se realizarán de la siguiente forma:
            <ul>
                <li>Primer pago, a continuación de la inscripción.</li>
                <li>Segundo pago, con fecha máxima el {{ $fechaPlazo2c2 }}.</li>
            </ul>
        </li>
        <li><strong>Pago en 1 recibo.</strong> A continuación de la inscripción.</li>
    </ul>

    <p><strong>Las formas de pago de los recibos:</strong></p>
    <ol>
        <li>Presencialmente en la oficina del Club, pudiéndose realizar tanto en metálico como con tarjeta bancaria.</li>
        <li>A través de transferencia bancaria a la cuenta de la Caixa a nombre del Club Deportivo Balonmano Laguna, con número IBAN: <strong>ES33 2100 4332 5801 0024 1501</strong>, poniendo en el concepto de la transferencia el nombre del jugador.</li>
    </ol>

    <p>Los pagos de los recibos se deben realizar convenientemente y en su fecha. De no ser así, se procederá al bloqueo de la ficha federativa del jugador hasta que se solucione el problema.</p>

    <p>Todo aquel que quiera, podrá adelantar el pago de los recibos.</p>

    <p>Para poder solventar cualquier situación especial o incidencia con respecto al pago/s de la/s cuota/s, contactar con el Club por correo a la dirección <strong>bmnlaguna@gmail.com</strong>, o personalmente en la oficina. La oficina se sitúa en el <strong>Polideportivo Municipal de Laguna de Duero (Avd de las Salinas nº3)</strong>, y abre los miércoles y viernes de 19 a 21 horas.</p>

    <p>La equipación de juego se compra a parte, realizando el pedido en la oficina de <strong>Macrón Sports Hub</strong> en <strong>Calle Isabel de Castilla Nº9 en Arroyo de la Encomienda (Valladolid)</strong>, y hasta el 30 de noviembre de 2026. Se recibirán instrucciones al respecto en el mail que se envía a los padres junto con el primer justificante de pago del precio de la actividad.</p>

</body>
</html>
