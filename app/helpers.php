<?php
use \BMLaguna\Categoria;

if (! function_exists('eliminar_tildes')){
    function eliminar_tildes($cadena){

        //Codificamos la cadena en formato utf8 en caso de que nos de errores
        //$cadena = utf8_encode($cadena);
    
        //Ahora reemplazamos las letras
        $cadena = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $cadena
        );
    
        $cadena = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $cadena );
    
        $cadena = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $cadena );
    
        $cadena = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $cadena );
    
        $cadena = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $cadena );
    
        $cadena = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'N', 'c', 'C'),
            $cadena
        );
    
        return $cadena;
    }
}

if (! function_exists('mostrar_categoria')){
    function mostrar_categoria($f_nacimiento, $temporada){
        $categorias = Categoria::all();
        $edadTemp = $temporada - date('Y', strtotime($f_nacimiento));

        foreach ($categorias as $categoria){
            if (($edadTemp >= $categoria->edad) && ($edadTemp < ($categoria->edad + $categoria->duracion)) ){
                return $categoria;
            }
        }
        return new Categoria;
    }
}

if (! function_exists('telefono_normalizado_whatsapp_digits')) {
    /**
     * Devuelve solo dígitos en formato internacional para wa.me (sin +), o null si no es usable.
     * Pensado para números españoles (9 cifras) y valores ya con prefijo 34.
     */
    function telefono_normalizado_whatsapp_digits($raw)
    {
        if ($raw === null || $raw === '') {
            return null;
        }
        $digits = preg_replace('/\D+/', '', $raw);
        if ($digits === '') {
            return null;
        }
        $len = strlen($digits);
        // España: 9 cifras (móvil / fijo local)
        if ($len === 9 && strpos('6789', $digits[0]) !== false) {
            return '34'.$digits;
        }
        // 34 + 9 cifras
        if ($len === 11 && substr($digits, 0, 2) === '34') {
            return $digits;
        }
        // 0034…
        if ($len >= 13 && substr($digits, 0, 4) === '0034') {
            return substr($digits, 2);
        }
        // Otros formatos internacionales razonables (10–15 dígitos)
        if ($len >= 10 && $len <= 15) {
            return $digits;
        }

        return null;
    }
}

if (! function_exists('whatsapp_wa_me_url')) {
    /**
     * URL wa.me para abrir WhatsApp con mensaje pre-rellenado, o null si el teléfono no es válido.
     */
    function whatsapp_wa_me_url($telefonoRaw, $mensaje)
    {
        $digits = telefono_normalizado_whatsapp_digits($telefonoRaw);
        if ($digits === null) {
            return null;
        }

        return 'https://wa.me/'.$digits.'?text='.rawurlencode($mensaje);
    }
}