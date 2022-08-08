<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <span class="flow-text">Saludos desde el Club Balonmano Laguna.</span>



    <p align="justify">Nuestra firme intención es comenzar los entrenamientos sin contacto, como especifican las autoridades sanitarias, a la mayor bevedad posible y de forma progresiva. Para ello hemos elaborado un protocolo de actuación para cuerpo técnico y jugadores.</p>
    <p align="justify">A fin de informar a los miembros del club, y para agilizar al máximo el comienzo de los entrenamientos, este correo lleva adjuntos los siguientes documentos: </p>
    <ul>
        <li type="disc">Protocolo de actuación frente a COVID19 en lo que refiere a jugadores.</li>
        <li type="disc">Autorización y Declaración Responsable para participar en los entrenamientos y otras actividades organizadas por el Club Balonmano Laguna. Esta declaración se puede entregar a la vuelta de este correo, o bien al cuerpo técnico del equipo el primer día de entrenamiento. Es imprescindible para poder participar en los mismos.</li>
        <li type="disc">Documento de normas básicas del club. Como miembro del Club Balonmano Laguna se debe acatar y firmar este documento aprobado por asamblea. Al igual que el anterior, se podrá entregar firmado a la vuelta de este correo, o bien al cuerpo técnico elprimer día de entrenamiento.</li>
    </ul>

    <p align="justify">El calendario de entrenamientos para cada grupo se informará convenientemente en los próximos días.</p>
    @if ($pendiente == 'SI')
        <p align="justify">Por otra parte, en nuestra base de datos no consta que haya realizado el pago de la preinscripción que ha realizado con nosotros y que, sin ella, no será posible comenzar los entrenamientos con el equipo. Como siempre, está habilitada la opcion de transferencia a la cuenta de La Caixa IBAN ES33 2100 4332 5801 0024 1501, poniendo como beneficiario "Club Balonmano Laguna" y en el asunto el nombre y apellidos del jugador. Las opciones de pago en oficina, tanto en efectivo como con tarjeta quedarán supeditadas a la disponibilidad de la misma que tengamos en los próximos meses. No obstante, si tiene alguna duda al respecto, no dude en ponerse en contacto con nosotros.</p>
    @elseif (($miembro->aPagar($tActual) - $miembro->pagado($tActual)) > 0)
        <p align="justify">Por otra parte, quedaría pendiente de pago {{$miembro->aPagar($tActual) - $miembro->pagado($tActual)}} euros, correspondientes al resto del pago de Inscripción. Somos conscientes de la situación y hemos decidido que el plazo para este segundo pago venza el 15 de enero de 2021. Como siempre, se habilita la opcion de transferencia a la cuenta de La Caixa IBAN ES33 2100 4332 5801 0024 1501, poniendo como beneficiario "Club Balonmano Laguna" y en el asunto el nombre y apellidos del jugador. Las opciones de pago en oficina, tanto en efectivo como con tarjeta quedarán supeditadas a la disponibilidad de la misma que tengamos en los próximos meses.</p>
    @endif

    <p align="justify">Desde la Junta Directiva deseamos que todo se lleve a cabo sin problemas para que nuestros jugadores puedan seguir disfrutando del deporte y dar un paso más hacía la normalidad que todos deseamos.</p>
    <p align="justify">Reciban un cordial Saludo</p>
    <p align="justify">La Junta Directiva del Club Balonmano Laguna.</p>

</body>
</html>