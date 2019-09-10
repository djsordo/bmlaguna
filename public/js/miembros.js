var contador = 1;
var contEmail = 1;

function comprueba(tipo){
    var aux = 1;

    if (document.getElementById(tipo).value == ""){
        return false;
    }
    else {
        if (tipo == "tel") aux = contador;
        else if (tipo == "email") aux = contEmail;
        else aux = 0;
        
    }
    
    for (i = 1; i < aux; i++){
        console.log(tipo+i);
        if (document.getElementById(tipo+i).value == ""){
            return false;
        }
    }

    return true;
}

function habilita(tipo){
    // Ponemos el primer carácter en mayúscula
    Tipo = tipo.charAt(0).toUpperCase() + tipo.slice(1);

    if (comprueba(tipo)){
        document.getElementById('add'+Tipo).classList.remove("disabled");
    }
    else{
        document.getElementById('add'+Tipo).classList.add("disabled");
    }
}
function creaTelefono(){
    var clonTel = document.getElementById("telefonoClon");
    var copia = clonTel.cloneNode(true);
    copia.id = copia.id + contador;
    copia.childNodes[1].childNodes[1].id = copia.childNodes[1].childNodes[1].id + contador;
    copia.childNodes[1].childNodes[3].htmlFor = copia.childNodes[1].childNodes[3].htmlFor + contador;
    copia.childNodes[3].childNodes[1].id = copia.childNodes[3].childNodes[1].id + contador;
    copia.childNodes[3].childNodes[3].htmlFor = copia.childNodes[3].childNodes[3].htmlFor + contador;

    document.getElementById('cuerpoTel').appendChild(copia);
    document.getElementById("tel"+contador).value = "";
    document.getElementById("des"+contador).value = "";

    contador = contador +1;
    document.getElementById('delTel').classList.remove("disabled");
    document.getElementById('addTel').classList.add("disabled");

    // Hacer que se deshabilite el botón de añadir si no hay nada en teléfono.
    copia.childNodes[1].childNodes[1].onblur = function(){
        habilita('tel');
    }
}

function creaEmail(){
    var clonTel = document.getElementById("emailClon");
    var copia = clonTel.cloneNode(true);
    copia.id = copia.id + contEmail;
    copia.childNodes[1].childNodes[1].id = copia.childNodes[1].childNodes[1].id + contEmail;
    copia.childNodes[1].childNodes[3].htmlFor = copia.childNodes[1].childNodes[3].htmlFor + contEmail;
    copia.childNodes[3].childNodes[1].id = copia.childNodes[3].childNodes[1].id + contEmail;
    copia.childNodes[3].childNodes[3].htmlFor = copia.childNodes[3].childNodes[3].htmlFor + contEmail;

    document.getElementById('cuerpoEmail').appendChild(copia);
    document.getElementById("email"+contEmail).value = "";
    document.getElementById("desEmail"+contEmail).value = "";

    contEmail = contEmail +1;
    document.getElementById('delEmail').classList.remove("disabled");
    document.getElementById('addEmail').classList.add("disabled");

    copia.childNodes[1].childNodes[1].onblur = function(){
        habilita('email');
    }
}
