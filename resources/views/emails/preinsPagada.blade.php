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
    <p align="justify">Adjunto se envía un documento con el recibo justificante de pago de la misma y la hoja de tallaje.</p>
    <p align="justify">Dentro del mismo, para los nuevos jugadores, o aquellos jugadores que
        renueven de la temporada anterior y que quieran obtener algún reemplazo de
        prenda, encontrará otro resguardo que le permitirá realizar la prueba de la
        equipación a partir del 22 de agosto en la tienda de Justo Muñoz del Centro
        Comercial Rio Shopping en Arroyo de la encomienda. Tras la prueba de la
        ropa, Justo Muñoz les llamará cuando esté preparada la misma, y
        posteriormente realizarán allí el pago de lo pedido.</p>
    <p align="justify">Los <u>jugadores de campo nuevos</u> deberán adquirir como mínimo las siguientes
        prendas: las dos camisetas de juego, pantalón corto y chaqueta del chándal,
        pudiendo pedir a mayores el pantalón de chándal y otras prendas que
        estimen, como anorak, mochila, etc.</p>
    <p align="justify">Los <u>porteros nuevos</u> deberán adquirir como mínimo las siguientes prendas:
        sudadera de portero, pantalón de portero y chaqueta de chándal, pudiendo
        pedir a mayores el pantalón de chándal, camiseta roja y otras prendas que
        estimen, como anorak, mochila, etc.</p>
    <p align="justify">Los <u>jugadores de campo y porteros</u> que renuevan de la temporada anterior,
        antes de ir a Justo Muñoz, si es que necesitan algún reemplazo, pueden pasar
        por la oficina para ver si tenemos talla de lo que necesiten.</p>
    <p align="justify">Los precios de las prendas para esta temporada serán los siguientes:</p>
    <div class="datagrid">
        <table align="center">
            <thead>
                <tr>
                    <th>DENOMINACIÓN PRENDA</th>
                    <th>REFERENCIA</th>
                    <th>COLOR</th>
                    <th>PVP</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Camiseta Sublimada</td>
                    <td>JM</td>
                    <td>Negra</td>
                    <td>16,00</td>
                </tr>
                <tr>
                    <td>Camiseta Sublimada</td>
                    <td>09845</td>
                    <td>Roja</td>
                    <td>14,00</td>
                </tr>
                <tr>
                    <td>Short Polo</td>
                    <td>13800</td>
                    <td>Negro</td>
                    <td>7,20</td>
                </tr>
                <tr>
                    <td>Chaqueta Chándal Capri</td>
                    <td>15115</td>
                    <td>Roja/Negra</td>
                    <td>24,95</td>
                </tr>
                <tr>
                    <td>Pantalón Chándal Capri</td>
                    <td>16629</td>
                    <td>Negro</td>
                    <td>15,80</td>
                </tr>
                <tr>
                    <td>Pantalón Gama Portero</td>
                    <td>08490</td>
                    <td>Negro</td>
                    <td>13,00</td>
                </tr>
                <tr>
                    <td>Sudadera Nocaut Portero</td>
                    <td>15148</td>
                    <td>Azul Marino</td>
                    <td>23,25</td>
                </tr>
                <tr>
                    <td>Anorak Kiev</td>
                    <td>13761</td>
                    <td>Negro</td>
                    <td>35,00</td>
                </tr>
                <tr>
                    <td>Chaqueta Forrada Gama</td>
                    <td>13761</td>
                    <td>Negro</td>
                    <td>30,00</td>
                </tr>
                <tr>
                    <td>Polo mc Capri</td>
                    <td>15117</td>
                    <td>Rojo/Negro</td>
                    <td>12,00</td>
                </tr>
                <tr>
                    <td>Mochila Rin</td>
                    <td>07243</td>
                    <td>Roja</td>
                    <td>25,00</td>
                </tr>
            </tbody>
        </table>
    </div>


    <p align="justify">Para cualquier duda que tengáis, hemos habilitado el siguiente número de móvil para
        contestar por whatsapp (641245263). Seguimos manteniendo el correo del club, al que
        también podéis acudir (bmnlaguna@gmail.com). A través de ambos medios se tratará
        de contestar a la mayor brevedad posible.</p>

    <p align="justify">Muchas gracias y bienvenido al Club Balonmano Laguna.</p>

    <p>Un saludo</p>
</body>
</html>
