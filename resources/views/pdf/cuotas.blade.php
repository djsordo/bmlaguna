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
        Estas son las cuotas para la temporada. A partir de esta temporada la equipación será gestionada aparte por una empresa externa, de modo que en la cuota no
        está incluido el coste de la misma. La equipación de la temporada pasada es válida para la actual, así que los jugadores que este año han formado parte del club,
         no necesitan adquirir una nueva. Para los nuevos jugadores, o para poder renovar alguna de las prendas de los jugadores veteranos, se abrirá un plazo, a partir del
         24 de agosto, para poder probar la ropa. Se avisará convenientemente del lugar de dicha prueba.
    </p>
    <table width="100%">
        <tr>
            <th colspan="7">Categoría</th>
            <th colspan="3">Nacimiento</th>
            <th colspan="2">Precio</th>
        </tr>

        @foreach ($categorias as $categoria)
            <tr>
                <td colspan="7">{{$categoria->descripcion}}</td>
                <td colspan="3">{{$categoria->rangoannos($temporada)[0]}} - {{$categoria->rangoannos($temporada)[1]}}</td>
                <td colspan="2">{{$categoria->precio_inscripcion}}</td>
            </tr>
        @endforeach

    </table>

    <p>
        Si se elige el pago en dos partes, la segunda deberá ser satisfecha antes del 15 de noviembre. De no ser así, se procederá al bloqueo de la ficha federativa del jugador
        hasta que se solucione el problema. Para poder solventar cualquier situación especial con respecto al pago de la cuota, contactar con el club por correo a la dirección
        bmlagunadircc@gmail.com, o personarse en la oficina en los horarios habituales.
    </p>

</body>
</html>
