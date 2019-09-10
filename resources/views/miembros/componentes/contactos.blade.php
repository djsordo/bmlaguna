<div class="row card-panel">
        <div class="section row">
            <span class="card-title col s12"><strong class="flow-text">Formas de contacto</strong></span>
        </div>
        <div id="cuerpoTel">
            <div id="telefonoClon" class="valign-wrapper">
                <div class="input-field col s4">
                    <input type="tel" id="tel" name="telefonos[]" class="validate">
                    <label for="tel">Telefono:</label>
                </div>

                <div class="input-field col s8">
                    <input type="text" id="des" name="descripciones[]" class="validate">
                    <label for="des">Descripción:</label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col s12">
                <a class="btn blue right disabled" id="delTel"><i class="material-icons">remove</i></a>
                <a class="btn red right disabled" id="addTel"><i class="material-icons">add</i></a>
            </div>
        </div>               
        @if (!is_null($telefonos))
            @foreach ($telefonos as $telefono)
                <script type="text/javascript">
                    console.log(contador);
                    creaTelefono();
                    document.getElementById('tel'+(contador-1)).value = '{{ $telefono->telefono }}';
                    document.getElementById('des'+(contador-1)).value = '{{ $telefono->descripcion }}';
                </script>
            @endforeach
        @endif


        <div id="cuerpoEmail">
            <div id="emailClon" class="valign-wrapper">
                <div class="input-field col s4">
                    <input type="email" id="email" name="emails[]" class="validate">
                    <label for="email">Correo Electrónico:</label>
                </div>

                <div class="input-field col s8">
                    <input type="text" id="desEmail" name="desEmails[]" class="validate">
                    <label for="desEmail">Descripción:</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <a class="btn blue right disabled" id="delEmail"><i class="material-icons">remove</i></a>
                <a class="btn red right disabled" id="addEmail"><i class="material-icons">add</i></a>
            </div>
        </div>

        @if (!is_null($emails))
            @foreach ($emails as $email)
                <script type="text/javascript">
                    console.log(contador);
                    creaEmail();
                    document.getElementById('email'+(contEmail-1)).value = '{{ $email->email }}';
                    document.getElementById('desEmail'+(contEmail-1)).value = '{{ $email->descripcion}}';
                </script>
            @endforeach
        @endif
    </div>

    <script>
        habilita('tel');
        habilita('email');

        // Botón para crear teléfono nuevo.
        document.getElementById('addTel').onclick = creaTelefono;

        // Botón para crear email nuevo.
        document.getElementById('addEmail').onclick = creaEmail;
        // Para que se habilite el botón añadir telefono si se pone algo en telefono

        document.getElementById('tel').onblur = function(){
            habilita('tel');
        }

        // Para que se habilite el botón añadir email si se pone algo en email
        document.getElementById('email').onblur = function(){
            habilita('email');
        }

        // Botón para borrar teléfono.
        document.getElementById('delTel').onclick = function(){
            contador = contador - 1;
            var clonTel = document.getElementById("telefonoClon"+contador);
            document.getElementById('cuerpoTel').removeChild(clonTel);
            if (contador == 1){
                document.getElementById('delTel').classList.add("disabled");
                if (document.getElementById('tel').value != "") {
                    document.getElementById('addTel').classList.remove("disabled");
                }
            }
        }

        // Botón para borrar email.
        document.getElementById('delEmail').onclick = function(){
            contEmail = contEmail - 1;
            var clonTel = document.getElementById("emailClon"+contEmail);
            document.getElementById('cuerpoEmail').removeChild(clonTel);
            if (contEmail == 1){
                document.getElementById('delEmail').classList.add("disabled");
                if (document.getElementById('email').value != "") {
                    document.getElementById('addEmail').classList.remove("disabled");
                }
            }
        }
    </script>