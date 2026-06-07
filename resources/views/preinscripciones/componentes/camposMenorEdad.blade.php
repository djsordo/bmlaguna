<script>
(function () {
    var camposMenorEdad = ['centroEducativo', 'nombreR1', 'apellido1R1'];

    function edadReal(fechaNacimiento) {
        if (!fechaNacimiento) {
            return null;
        }

        var hoy = new Date();
        var nacimiento = new Date(fechaNacimiento + 'T00:00:00');
        var edad = hoy.getFullYear() - nacimiento.getFullYear();
        var mes = hoy.getMonth() - nacimiento.getMonth();

        if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
            edad--;
        }

        return edad;
    }

    function actualizarCamposMenorEdad(requiere) {
        camposMenorEdad.forEach(function (id) {
            var input = document.getElementById(id);
            if (!input) {
                return;
            }

            var label = document.querySelector('label[for="' + id + '"]');
            var textoBase = label ? (label.getAttribute('data-label') || label.textContent.replace(/\s*\*$/, '')) : '';

            if (requiere) {
                input.setAttribute('required', 'required');
                if (label) {
                    label.textContent = textoBase + ' *';
                }
            } else {
                input.removeAttribute('required');
                if (label) {
                    label.textContent = textoBase;
                }
            }
        });
    }

    function evaluarFechaNacimiento() {
        var inputFecha = document.getElementById('f_nacimiento');
        if (!inputFecha) {
            return;
        }

        var edad = edadReal(inputFecha.value);
        var requiere = edad === null || edad < 18;
        actualizarCamposMenorEdad(requiere);
    }

    document.addEventListener('DOMContentLoaded', function () {
        var inputFecha = document.getElementById('f_nacimiento');
        if (!inputFecha) {
            return;
        }

        inputFecha.addEventListener('change', evaluarFechaNacimiento);
        inputFecha.addEventListener('input', evaluarFechaNacimiento);
        evaluarFechaNacimiento();
    });
})();
</script>
