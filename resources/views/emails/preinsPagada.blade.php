<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style type="text/css">
        body {
            font: normal 12px/150% Arial, Helvetica, sans-serif;
        }

        .datagrid table {
            border-collapse: collapse;
            text-align: left;
            width: 100%;
        }

        .datagrid {
            font: normal 12px/150% Arial, Helvetica, sans-serif;
            background: #fff;
            overflow: hidden;
            border: 1px solid #8C8C8C;
            -webkit-border-radius: 6px;
            -moz-border-radius: 6px;
            border-radius: 6px;
        }

        .datagrid table td, .datagrid table th {
            padding: 4px 3px;
        }

        .datagrid table thead th {
            background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #8C8C8C), color-stop(1, #7D7D7D) );
            background:-moz-linear-gradient( center top, #8C8C8C 5%, #7D7D7D 100% );
            filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#8C8C8C', endColorstr='#7D7D7D');
            background-color:#8C8C8C;
            color:#FFFFFF;
            font-size: 15px;
            font-weight: bold;
            border-left: 1px solid #A3A3A3;
        }

        .datagrid table thead th:first-child {
            border: none;
        }

        .datagrid table tbody td {
            color: #7D7D7D;
            border-left: 1px solid #DBDBDB;
            font-size: 12px;
            font-weight: normal;
        }

        .datagrid table tbody .alt td {
            background: #EBEBEB;
            color: #7D7D7D;
        }

        .datagrid table tbody td:first-child {
            border-left: none;
        }

        .datagrid table tbody tr:last-child td {
            border-bottom: none;
        }

    </style>
</head>
<body>
    <h2 align="center">CLUB BALONMANO LAGUNA</h2>
    <p align="justify">Le informamos que se ha comprobado el pago de la preinscripción {{$nPreinscripcion}}.</p>
    <p align="justify">Adjunto se envía un documento con el recibo justificante de pago de la misma.</p>

    <p align="justify">Os recordamos que para cualquier duda que tengáis, os podemos atender en la oficina del Club los miércoles y viernes de 19 a 21h.</p>
    <p align="justify">Además, hemos habilitado el siguiente número de móvil para contestar por whatsapp (641245263), y seguimos manteniendo el correo del club, al que también podéis acudir (bmnlaguna@gmail.com). A través de ambos medios se tratará de contestar a la mayor brevedad posible.</p>
    <p align="justify">Muchas gracias y bienvenido al Club Balonmano Laguna.</p>

    <p>Un saludo</p>
</body>
</html>
