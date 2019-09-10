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
                <img src="images/escudo.png" width="50px">
            </td>
            <td colspan="6">
                <h3>CLUB BALONMANO LAGUNA</h3>
            </td>
            <td colspan="2">
                <span class="cabecera">Nº SOCIO:</span> <b>{{$miembro->nSocio}}</b>
            </td>
            <td colspan="3">
                <span class="cabecera">Nº RECIBO:</span> <b>R19-001</b><br>
                <span class="cabecera">Fecha:</span> <b>{{date('d-m-Y')}}</b>
            </td>
            
        </tr>

        <tr>
            <td colspan="12">
                <span class="cabecera">N.I.F:</span> <b>{{$miembro->nif}}</b>
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
                <span class="cabecera">Nombre del responsable:</span> <b>{{$resp1->nombre.' '.$resp1->apellido1.' '.$resp1->apellido2}}</b>
            </td>
            
            <td colspan="6">
                <span class="cabecera">Nombre del responsable:</span> <b>{{$resp2->nombre.' '.$resp2->apellido1.' '.$resp2->apellido2}}</b>
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <span class="cabecera">Teléfonos de contacto:</span>
                <b>
                @foreach ($miembro->telefonos as $telefono)
                    {{$telefono->telefono.' '}}
                @endforeach
                </b>
            </td>
            <td colspan="6">
                <span class="cabecera">eMail:</span>
                <b>
                @foreach ($miembro->emails as $email)
                    {{$email->email.' '}}
                @endforeach
                </b>
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <span class="cabecera">Dirección:</span> <b>{{$miembro->domicilio}}</b>
            </td>
            <td colspan="6">
                <span class="cabecera">Código Postal:</span> <b>{{$miembro->c_postal}}</b>
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <span class="cabecera">Localidad:</span> <b>{{$miembro->localidad}}</b>
            </td>
            <td colspan="6">
                <span class="cabecera">Provincia:</span> <b>{{$miembro->provincia}}</b>
            </td>
        </tr>
         <tr>
            <td colspan="6">
                <span class="cabecera">IMPORTE DE LA PREINSCRIPCIÓN:</span> <b>60 euros</b><br>
                <i>A DESCONTAR DE LA CUOTA ANUAL</i>
            </td>
            <td colspan="6">
                <b>Por la presente entrego la cantidad de 60 euros</b>
            </td>
        </tr>
        <tr>
            <td colspan="12">
                <p class="texto">AVISO DE CONFIDENCIALIDAD: según lo dispuesto en la legislación en materia de protección de datos y por el RGPD UE 2016/679 de la LSSI (34/2002), garantizamos la confidencialidad de sus datos los cuales serán incluidos en un fichero de nuestra propiedad. Usted podrá ejercitar sus derechos de acceso, rectificación, cancelación o supresión, oposición, limitación del tratamiento o portabilidad de sus datos comunicándose por correo electrónico a <b>bmnlaguna@gmail.com</b> . Igualmente tiene usted derecho a presentar una reclamación ante la Agencia de Protección de Datos.</p>
            </td>
        </tr>
        <tr>
            <td colspan="12">
                <p class="texto"><b>RECIBO JUSTIFICANTE DE PAGO PARA EL CLUB</b><br>
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
                    Para ingreso bancario indicar Nº Recibo, Nombre y Apellidos del jugador.<br>
                    La Caixa <b>IBAN ES33 2100 4332 5801 0024 1501</b><br>
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
                <td colspan="2">
                    <span class="cabecera">Nº SOCIO:</span> <b>{{$miembro->nSocio}}</b>
                </td>
                <td colspan="3">
                    <span class="cabecera">Nº RECIBO:</span> <b>R19-001</b><br>
                    <span class="cabecera">Fecha:</span> <b>{{date('d-m-Y')}}</b>
                </td>
                
            </tr>
    
            <tr>
                <td colspan="12">
                    <span class="cabecera">N.I.F:</span> <b>{{$miembro->nif}}</b>
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
                    <span class="cabecera">Nombre del responsable:</span> <b>{{$resp1->nombre.' '.$resp1->apellido1.' '.$resp1->apellido2}}</b>
                </td>
                
                <td colspan="6">
                    <span class="cabecera">Nombre del responsable:</span> <b>{{$resp2->nombre.' '.$resp2->apellido1.' '.$resp2->apellido2}}</b>
                </td>
            </tr>
            <tr>
                <td colspan="6">
                    <span class="cabecera">Teléfonos de contacto:</span>
                    <b>
                    @foreach ($miembro->telefonos as $telefono)
                        {{$telefono->telefono.' '}}
                    @endforeach
                    </b>
                </td>
                <td colspan="6">
                    <span class="cabecera">eMail:</span>
                    <b>
                    @foreach ($miembro->emails as $email)
                        {{$email->email.' '}}
                    @endforeach
                    </b>
                </td>
            </tr>
            <tr>
                <td colspan="6">
                    <span class="cabecera">Dirección:</span> <b>{{$miembro->domicilio}}</b>
                </td>
                <td colspan="6">
                    <span class="cabecera">Código Postal:</span> <b>{{$miembro->c_postal}}</b>
                </td>
            </tr>
            <tr>
                <td colspan="6">
                    <span class="cabecera">Localidad:</span> <b>{{$miembro->localidad}}</b>
                </td>
                <td colspan="6">
                    <span class="cabecera">Provincia:</span> <b>{{$miembro->provincia}}</b>
                </td>
            </tr>
             <tr>
                <td colspan="6">
                    <span class="cabecera">IMPORTE DE LA PREINSCRIPCIÓN:</span> <b>60 euros</b><br>
                    <i>A DESCONTAR DE LA CUOTA ANUAL</i>
                </td>
                <td colspan="6">
                    <b>Por la presente entrego la cantidad de 60 euros</b>
                </td>
            </tr>
            <tr>
                <td colspan="12">
                    <p class="texto">AVISO DE CONFIDENCIALIDAD: según lo dispuesto en la legislación en materia de protección de datos y por el RGPD UE 2016/679 de la LSSI (34/2002), garantizamos la confidencialidad de sus datos los cuales serán incluidos en un fichero de nuestra propiedad. Usted podrá ejercitar sus derechos de acceso, rectificación, cancelación o supresión, oposición, limitación del tratamiento o portabilidad de sus datos comunicándose por correo electrónico a <b>bmnlaguna@gmail.com</b> . Igualmente tiene usted derecho a presentar una reclamación ante la Agencia de Protección de Datos.</p>
                </td>
            </tr>
            <tr>
                <td colspan="12">
                    <p class="texto"><b>RECIBO JUSTIFICANTE DE PAGO PARA EL INTERESADO</b><br>
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
                        Para ingreso bancario indicar Nº Recibo, Nombre y Apellidos del jugador.<br>
                        La Caixa <b>IBAN ES33 2100 4332 5801 0024 1501</b><br>
                        La Junta Directiva</p>
                </td>
            </tr>
        </table>
</body>
</html>