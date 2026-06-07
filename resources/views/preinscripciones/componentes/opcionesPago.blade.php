<div class="row card-panel">
    <div class="row section">
        <span class="card-title col s12"><strong class="flow-text">OPCIONES DE PAGO</strong></span>
    </div>

    <div class="col s12">
        <div class="col s10">
            <strong>Pago en 1 recibo.</strong> A continuación de la inscripción.
        </div>
        <div class="col s2">
            <label>
                <input name="modalidad_cuotas" type="radio" value="1" required/>
                <span></span>
            </label>
        </div>
    </div>
    <div class="col s12">
        <div class="col s10">
            <strong>Pago en 2 recibos.</strong> Primer pago a la inscripción; segundo en la fecha indicada en la tabla de cuotas.
        </div>
        <div class="col s2">
            <label>
                <input name="modalidad_cuotas" type="radio" value="2" required/>
                <span></span>
            </label>
        </div>
    </div>
    <div class="col s12">
        <div class="col s10">
            <strong>Pago en 3 recibos.</strong> Primer pago a la inscripción; segundo y tercero en las fechas indicadas en la tabla de cuotas.
        </div>
        <div class="col s2">
            <label>
                <input name="modalidad_cuotas" type="radio" value="3" required/>
                <span></span>
            </label>
        </div>
    </div>

    <div class="col s12">
        <p align="justify">Cuotas para la temporada {{ $temporada->descripcion }} en este <a href="{{ route('pdf-cuotas', compact('temporada')) }}">enlace</a>.</p>
    </div>

    <div class="col s12">
        <p align="justify">AVISO DE CONFIDENCIALIDAD: según lo dispuesto en la legislación en materia de protección de datos y por el RGPD UE 2016/679 de la LSSI (34/2002), garantizamos la confidencialidad de sus datos los cuales serán incluidos en un fichero de nuestra propiedad. Usted podrá ejercitar sus derechos de acceso, rectificación, cancelación o supresión, oposición, limitación del tratamiento o portabilidad de sus datos comunicándose por correo electrónico a <b>bmlagunadircc@gmail.com</b>. Igualmente tiene usted derecho a presentar una reclamación ante la Agencia de Protección de Datos.</p>
        <p align="justify">Así mismo, les pedimos que lean las <a href="/docsInscripcion/Normas.pdf" target="_blank">normas del club</a>, para poder aceptarlas posteriormente.</p>
    </div>
</div>
