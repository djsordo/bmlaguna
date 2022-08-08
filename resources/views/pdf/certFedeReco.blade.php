<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Equipación</title>
</head>
<style>
     @font-face {
        font-family: Cambria;
        src:local('Cambria') format('truetype');
        font-weight: normal;
        font-style: normal
    } 
    
    body { font-family: Cambria, 'Times New Roman', Times, serif;
            font-size:9pt  }
    
    hr { 

        noshade: noshade;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    p { font-size: 16pt;
        margin-top: 5px;
        margin-bottom: 5px    }

/*    
    .texto {
        font-size: 7pt;
        text-align: center;
    }
    .tabla {
        border: 1px solid black;
        border-collapse: collapse;
    } */

    .cabecera {
        font-size: 14pt;
        font-style : normal;
        text-align: center;
        margin-top: 40px;
    }
    .cabecera2 {
        font-size: 20pt;
        text-align: center;
    }
    .centrar {
        text-align: center;
    }
    .certifica {
        font-size: 14pt;
        font-style : normal;
        text-align: center;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .datos {
        font-size: 14pt;
        margin-top:10px;
    }

    .derecha {
        width: 50%;
        float: right;
    }
    
    .izquierda {
        width: 50%;
        float: left;
    }

    .sello {
        display: flex;
        align-items: flex-start;
    }

</style>
<body>
    <div class="centrar">
        <img src="images/cabeceraCertFedeReco.jpg" width="80%">
    </div>
    
    <div class="cabecera">
        <b>CERTIFICACIÓN DE APTO/NO APTO PARA LA PRÁCTICA DE BALONMANO</b>
    </div>

    <div class="cabecera2">
        <b><i>(APTO / NO APTO MÉDICO)</i></b>
    </div>
    
    <hr/>

    <div>
        <i>Datos del Secretario del Club o responsable con poder suficiente</i>
    </div>

    <div class="datos">
        <b>D./Dª</b>&#160;&#160;&#160;&#160;&#160;Juan José Marijuan Merino
    </div>

    <div class="datos">
        <div class="izquierda"><b>DNI</b>&#160;&#160;&#160;&#160;&#160;13098787B</div>
        <div class="derecha"><b>CARGO</b>&#160;&#160;&#160;&#160;&#160;Presidente</div>
    </div>

    <div class="datos">
        <b>CLUB</b>&#160;&#160;&#160;&#160;&#160;Deportivo Balonmano Laguna
    </div>

    <hr/>

    <div>
        <i>Datos del Jugador/a o Staff Técnico</i>
    </div>

    <div class="datos">
        <b>D./Dª</b>&#160;&#160;&#160;&#160;&#160;{{$miembro->nombre .' '. $miembro->apellido1 .' '. $miembro->apellido2}}
    </div>

    <div class="datos">
        <b>DNI/NIE/PASAPORTE</b>&#160;&#160;&#160;&#160;&#160;{{$miembro->nif}}
    </div>

    <div class="datos">
        <b>Fecha de Nacimiento</b>&#160;&#160;&#160;&#160;&#160;{{date('d-m-Y', strtotime($miembro->f_nacimiento) )}}
    </div>

    <div class="datos">
        <b>Club</b>&#160;&#160;&#160;&#160;&#160;Balonmano Laguna
    </div>

    <div class="datos">
        <b>Categoría</b>&#160;&#160;&#160;&#160;&#160;{{$miembro->categoria($tempActual->temporada)->descripcion .' '. $miembro->genero->descripcion}}
    </div>

    <div class="datos">
        <b>ESTADO MÉDICO (reconocimiento y resultado)<img src="images/check.png">APTO</b>
    </div>

    <hr/>

    <p><b>
        En calidad de Secretario del club o persona responsable con poder suficiente como para emitir este certificado,
        <b/>
    </p>

    <div class="certifica"><b>CERTIFICA</b></div>
    <p>
        <b>Que los datos recogidos en este impreso son ciertos y certifica a la Federación de Balonmano a la que dirige este escrito que el jugador referenciado ha sido reconocido y resultado APTO para la práctica del Balonmano, según consta en la documentación depositada en el club.</b>
    </p>
    <br/>
    <div>
        <i>Aprovechamos la ocasión para informarle que, conforme a la L.O. 15/1999, los datos de carácter personal que Ud. Nos ha proporcionado previamente forman parte de los ficheros de datos personales, titularidad de la Federación territorial en la que se inscriba cuyas finalidades son la gestión de licencias federativas. Sus datos podrían ser cedidos a la Real Federación Española de Balonmano.</i>
        <br/><br/>
        <i>Ud. puede ejercer sus derechos de rectificación, cancelación y oposición dirigiéndose a la federación Territorial en la que haya inscrito los mismos.</i>
    </div>
    <div class="datos">
        <div class="izquierda"><b>Fecha:</b>&#160;&#160;&#160;&#160;&#160;{{date('d-m-Y')}}</div>
        
        <div class="derecha"><b>Firma y sello:</b></div>
        <br/>
    </div>
    <div>
        <img style="float: right" src="images/SelloFirma.png" width="20%">
    </div>
</body>
</html>