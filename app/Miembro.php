<?php

namespace BMLaguna;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Arr;

use BMLaguna\Funcione;
use BMLaguna\Genero;
use BMLaguna\Documento;
use BMLaguna\Equipo;
use BMLaguna\Telefono;
use BMLaguna\Email;
use BMLaguna\Categoria;
use BMLaguna\Pago;
use BMLaguna\Temporada;
use BMLaguna\Equipacione;
use BMLaguna\Talla;
use BMLaguna\Preinscripcion;


class Miembro extends Model
{
    protected $fillable = ['nombre', 'apellido1', 'apellido2', 'nif', 'f_nacimiento', 'genero_id', 'domicilio', 'c_postal', 'localidad', 'provincia', 'dorsal', 'socio', 'responsable2_id', 'responsable1_id', 'f_baja', 'centroEducativo', 'obserMedicas', 'observaciones', 'nSocio', 'nomSerigrafia'];

    public function genero(){
        return $this->belongsTo('BMLaguna\Genero');
    }

    public function documentos(){
        return $this->belongsToMany('BMLaguna\Documento')->withPivot('id', 'ruta', 'f_entrega', 'f_caducidad');
    }

    public function fotos(){
        return $this->belongsToMany('BMLaguna\Documento')->withPivot('id', 'ruta', 'f_entrega', 'f_caducidad')->where('descripcion', 'foto')->orderBy('f_entrega', 'desc');
    }

    public function funciones(){
        return $this->belongsToMany('BMLaguna\Funcione', 'equipo_funcione_miembro', 'miembro_id', 'funcione_id')->withPivot('equipo_id')->orderBy('pivot_equipo_id', 'DESC');
    }

    public function equipos(){
        return $this->belongsToMany('BMLaguna\Equipo', 'equipo_funcione_miembro', 'miembro_id', 'equipo_id')->withPivot('funcione_id');
    }

    public function equipaciones(){
        return $this->belongsToMany('BMLaguna\Equipacione', 'equipacione_miembro_talla', 'miembro_id', 'equipacione_id')->withPivot('talla_id', 'f_prueba', 'f_entrega', 'f_pedido', 'f_llegada', 'f_envioseri', 'f_llegadaseri');
    }

    public function preinscripciones(){
        return $this->hasMany('BMLaguna\Preinscripcion');
    }

    public function equiposPorTemp(){
        $temp_id = 1;
        return $this->belongsToMany('BMLaguna\Equipo', 'equipo_funcione_miembro', 'miembro_id', 'equipo_id')
                    ->withPivot('funcione_id')
                    ->where('temporada_id', $temp_id);
    }

    public function telefonos(){
        return $this->hasMany('BMLaguna\Telefono');
    }

    public function emails(){
        return $this->hasMany('BMLaguna\Email');
    }

    public function pagos(){
        return $this->hasMany('BMLaguna\Pago');
    }

    // Calcula la edad del miembro en la temporada $temporada
    public function edadTemp($temporada){
        return $temporada - date('Y', strtotime($this->f_nacimiento));
        // return date('Y') - date('Y', strtotime($this->f_nacimiento));
    }

    // Calcula la edad del miembro a día de hoy
    public function edadReal(){
        $ahora = Carbon::now();
        return $ahora->diffInYears($this->f_nacimiento);
    }

    // Función que da la categoría del miembro.
    public function categoria($temporada){
        $categorias = Categoria::all();
        foreach ($categorias as $categoria){
            if (($this->edadTemp($temporada) >= $categoria->edad) && ($this->edadTemp($temporada) < ($categoria->edad + $categoria->duracion)) ){

                return $categoria;
            }
        }

        return new Categoria;
    }

    // Función que da la categoría según una edad y la temporada
    static public function categoriaEdad($f_nacimiento, $temporada){
        $categorias = Categoria::all();
        $edadTemp = $temporada - date('Y', strtotime($f_nacimiento));

        foreach ($categorias as $categoria){
            if (($edadTemp >= $categoria->edad) && ($edadTemp < ($categoria->edad + $categoria->duracion)) ){
                return $categoria;
            }
        }
        return new Categoria;
    }


    public function OficialEquipo($equipo_id){
        $funciones_id = Funcione::whereIn('descripcion', ['entrenador', 'delegado'])->select('id')->get();
        return $this->belongsToMany('BMLaguna\Funcione', 'equipo_funcione_miembro', 'miembro_id', 'funcione_id')
                    ->wherePivot('equipo_id', $equipo_id)
                    ->wherePivotIn('funcione_id', $funciones_id);
    }
    public function JugadorEquipo(){
        $funcion_id = Funcione::where('descripcion', 'jugador')->value('id');
        return $this->belongsToMany('BMLaguna\Funcione', 'equipo_funcione_miembro', 'miembro_id', 'funcione_id')
                    ->withPivot('equipo_id')
                    ->wherePivot('funcione_id', $funcion_id);
    }

    public function guardaResponsable($resp){

        $miembro = new Miembro();
        $miembro->nombre    = $resp['nombre'];
        $miembro->apellido1 = $resp['apellido1'];
        $miembro->apellido2 = $resp['apellido2'];
        $miembro->domicilio = $resp['domicilio'];
        $miembro->c_postal  = $resp['c_postal'];
        $miembro->provincia = $resp['provincia'];
        $miembro->localidad = $resp['localidad'];

        $miembro->save();

        return $miembro->id;
    }

    // Función que saca la ruta de la foto más reciente del miembro
    public function rutaFoto(){
        $fotos = $this->documentos->where('descripcion', 'foto');
        $ruta_max = 0;
        $ruta = null;
        foreach ($fotos as $foto){
            if ($ruta_max < $foto->pivot->ruta){
                $ruta = $foto->pivot->ruta;
                $ruta_max = $foto->pivot->ruta;
            }
        }
        return $ruta;
    }

    // Función que saca la ruta del DNI Frontal más reciente del miembro
    public function rutaDNIF(){
        $fotos = $this->documentos->where('descripcion', 'DNI Frontal');
        $fecha_max = date_create('1900-01-01');

        $ruta = null;
        foreach ($fotos as $foto){
            $fecha = date_create($foto->pivot->f_caducidad);
            if ($fecha_max <= $fecha){
                $ruta = $foto->pivot->ruta;
                $fecha_max = $fecha;
            }
        }

        return [$ruta, $fecha_max];
    }

    // Función que saca la ruta del DNI Trasero más reciente del miembro
    public function rutaDNIP(){
        $fotos = $this->documentos->where('descripcion', 'DNI Trasero');
        $fecha_max = date_create('1900-01-01');

        $ruta = null;
        foreach ($fotos as $foto){
            $fecha = date_create($foto->pivot->f_caducidad);
             if ($fecha_max <= $fecha){
                $ruta = $foto->pivot->ruta;
                $fecha_max = $fecha;
            }
        }

        return [$ruta, $fecha_max];
    }

    //Devuelve un array de cadenas con una descripción de las funciones del miembro.
    public function funcionesMiembro(){
        $cadena = array();

        foreach ($this->funciones as $funcion){
            $equipo = Equipo::find($funcion->pivot->equipo_id);
            $categoria = Categoria::find($equipo{'categoria_id'});
            $genero = Genero::find($equipo{'genero_id'});
            $temporada = Temporada::find($equipo{'temporada_id'});

            if ($funcion->descripcion == 'familiar'){
                $resps = Miembro::where('responsable1_id', $this->id)->
                                 orWhere('responsable2_id', $this->id)->
                                 get();
                foreach($resps as $resp){
                    array_push($cadena, '<em>' . ucfirst($funcion->descripcion) . '</em> de  ' .
                    '<a href="/miembros/' . $resp->id . '">' .
                    $resp->nombre . ' ' . $resp->apellido1 . ' ' . $resp->apellido2 .
                    '</a>');
                }
            }
            else{
                array_push($cadena, '<em>' . ucfirst($funcion->descripcion) . '</em> del equipo ' .
                '<a href="/equipos/' . $equipo{'id'} . '">' .
                $equipo{'nombre'} . '</a> de la categoría ' .
                $categoria{'descripcion'} . ' ' .
                ucfirst($genero{'descripcion'}) . ' ' .
                $temporada{'descripcion'});
            }
        }

        return $cadena;
    }

    // Función que devuelve un string con la categoría, género y si es de primer año o de segundo, según la temporada $temporada
    public function categoriaTemp($temporada){
        // Si es > 18 no ponemos lo de primer o segundo año
        $categoria_desc = $this->categoria($temporada)->descripcion;
        $genero_desc = $this->genero->descripcion;
        $subcategoria_desc = ($this->categoria($temporada)->edad == $this->edadTemp($temporada)) ? 'de primer año' : 'de segundo año';

        if ($this->edadTemp($temporada) >= 18) {
            return $categoria_desc . ' ' . $genero_desc;
        }
        else {
            return $categoria_desc . ' ' . $genero_desc . ' ' . $subcategoria_desc;
        }
    }

    public function scopeNombre($query, $textoBusqueda){
        if (trim($textoBusqueda) != ""){
            $textoBusqueda = str_replace(' ','%', $textoBusqueda);
            $query->where(DB::raw("concat(nombre, ' ', apellido1, ' ', IFNULL(apellido2, ' '),' d', IFNULL(dorsal, ' '), 'd s', IFNULL(nsocio, ' '), 's')"), "like",  "%$textoBusqueda%")
                    ->whereNull('f_baja');
        }
        return $query;
    }

    // Baja de un miembro del club, a la fecha dada
    public function baja($f_baja){
        $this->f_baja = $f_baja;
        $this->save();
    }

    // Reactivación de una baja
    public function activacion(){
        $this->f_baja = null;
        $this->save();
    }

    // Realiza un borrado físico del miembro y del resto de dependencias.
    public function borrar(){
        // Se borran todas sus funciones.
        $this->funciones()->detach();

        // Se quita de familiares
        $hijos = Miembro::where('responsable1_id', $this->id)->
                           orWhere('responsable2_id', $this->id)->get();
        foreach ($hijos as $hijo){
            if ($hijo->responsable1_id == $this->id){
                $hijo->responsable1_id = null;
            }
            else{
                $hijo->responsable2_id = null;
            }
            $hijo->save();
        }

        // Se borran los teléfonos y correos
        $this->telefonos()->delete();
        $this->emails()->delete();

        //Borro todos los documentos.
        foreach ($this->documentos as $documento){
            $ruta = '/fotos/'.$documento->pivot->ruta;
            unlink(public_path($ruta));
        }
        $this->documentos()->detach();


        // Borro el miembro en si.
        $this->delete();
    }

    // Esta función da una lista de posibles dorsales para un jugador
    public function dorsales(){
        $dorsales = array();
        $anteriores = array();
        $siguientes = array();

        $max = 99;
        $tempAct = Temporada::Tactual();

        for ($x = 1; $x<=$max; $x++){
            array_push($dorsales, $x);
        }

        if (!is_null($this->f_nacimiento)){
            $dorsCat = $this->categoria($tempAct->temporada)->dorsales($this->genero->descripcion);

            if (!is_null($this->categoria($tempAct->temporada)->anterior())){
                $anteriores = $this->categoria($tempAct->temporada)->anterior()->dorsales($this->genero->descripcion);
            }

            if (!is_null($this->categoria($tempAct->temporada)->siguiente())){
                $siguientes = $this->categoria($tempAct->temporada)->siguiente()->dorsales($this->genero->descripcion);
            }

            $dorsales = array_diff($dorsales,$dorsCat,$anteriores,$siguientes);
        }

        return $dorsales;
    }

    // esta función devuelve True si el miembro ha pagado la preinscripción en la temporada actual
    public function preinscrito(){
        $preinscripcion = Tipospago::where('descripcion', 'Preinscripcion')->first();
        $pago = $this->pagos->where('temporada_id', Temporada::Tactual()->id)
                            ->where('tipospago_id', $preinscripcion->id)->first();

        if (is_null($pago)){
            return False;
        }

        return True;
    }

    // Función que cuenta los inscritos de la temporada actual
    static public function nInscritos(){
        $miembros = Miembro::all();

        $cuenta = 0;

        foreach ($miembros as $miembro){
            if ($miembro->preinscrito()){
                $cuenta++;
            }
        }
        return $cuenta;
    }

    // Función que devuelve los miembros inscritos.
    static public function inscritos(){
        $miembros = Miembro::all();
        $clave = 0;
        foreach ($miembros as $miembro){
            if (!$miembro->preinscrito()){
                $miembros->pull($clave);
            }
            $clave++;
        }
        return $miembros;
    }

    // esta función devuelve True si el miembro se ha probado ropa en la temporada actual
    public function probado(){

        if ( !is_null($this->equipaciones()->where('temporada_id', Temporada::Tactual()->id)->get()) ){

            foreach($this->equipaciones()->where('temporada_id', Temporada::Tactual()->id)->get() as $equipacion){
                if($equipacion){
                    return true;
                }
            }
        }
        return false;
    }

    // Esta función devuelve el estado del NIF asociado al miembro.
    // Puede ser 'activo', 'caducado' o 'no existe'
    public function estadoNIF(){
        // coger el documento DNIF más moderno
        //$retorno = 'caducado';
        if ($this->documentos()->where('tipo', 'DNI')->where('subTipo', 'DNIF')->count() == 0){
            return 'no existe';
        }

        foreach ($this->documentos()->where('tipo', 'DNI')->where('subTipo', 'DNIF')->get() as $documento){
            if ($documento->pivot->f_caducidad >= date('Y-m-d')){
                return 'activo';
            }
            //dd($dnifs);
        }


        return 'caducado';

    }

    // Esta función crea un nuevo miembro dada una preinscripción ya pagada.
    static function nuevo(Preinscripcion $preinscripcion){
        $miembro = new Miembro;

        // Datos generales
        $miembro->nombre = $preinscripcion->nombre;
        $miembro->apellido1 = $preinscripcion->apellido1;
        $miembro->apellido2 = $preinscripcion->apellido2;
        $miembro->f_nacimiento = $preinscripcion->f_nacimiento;
        $miembro->genero_id = $preinscripcion->genero_id;
        $miembro->nif = $preinscripcion->nif;
        $miembro->domicilio = $preinscripcion->domicilio;
        $miembro->localidad = $preinscripcion->localidad;
        $miembro->provincia = $preinscripcion->provincia;
        $miembro->c_postal = $preinscripcion->c_postal;
        $miembro->socio = $preinscripcion->socio;
        $miembro->centroEducativo = $preinscripcion->centroEducativo;

        $miembro->save();

        // responsables

        // R1
        if (!is_null($preinscripcion->nombreR1) && !is_null($preinscripcion->apellido1R1)){
            // Ver si existe en la BD
            $resp = Miembro::where('nombre', $preinscripcion->nombreR1)->
                    where('apellido1', $preinscripcion->apellido1R1)->
                    where('apellido2', $preinscripcion->apellido2R1)->first();

            if (!is_null($resp)){
                $miembro->responsable1_id = $resp->id;
            }
            else{
                // Nuevo miembro
                $r1['nombre'] = $preinscripcion->nombreR1;
                $r1['apellido1'] = $preinscripcion->apellido1R1;
                $r1['apellido2'] = $preinscripcion->apellido2R1;
                $r1['domicilio'] = $preinscripcion->domicilio;
                $r1['c_postal']  = $preinscripcion->c_postal;
                $r1['provincia'] = $preinscripcion->provincia;
                $r1['localidad'] = $preinscripcion->localidad;

                $miembro->responsable1_id = $miembro->guardaResponsable($r1);

                // Poner la función de familiar.
                $responsable1= Miembro::find($miembro->responsable1_id);

                $funcione_id = DB::table('funciones')->where('descripcion', 'familiar')->value('id');
                if ($responsable1->funciones()->where('descripcion', 'familiar')->count() == 0){
                    $responsable1->funciones()->attach($funcione_id, ['equipo_id' => null]);
                }
            }
        }

        //
        if (!is_null($preinscripcion->nombreR2) && !is_null($preinscripcion->apellido1R2)){
            // Ver si existe en la BD
            $resp2 = Miembro::where('nombre', $preinscripcion->nombreR2)->
                    where('apellido1', $preinscripcion->apellido1R2)->
                    where('apellido2', $preinscripcion->apellido2R2)->first();

            if (!is_null($resp2)){
                $miembro->responsable2_id = $resp2->id;
            }
            else{
                // Nuevo miembro
                $r2['nombre'] = $preinscripcion->nombreR2;
                $r2['apellido1'] = $preinscripcion->apellido1R2;
                $r2['apellido2'] = $preinscripcion->apellido2R2;
                $r2['domicilio'] = $preinscripcion->domicilio;
                $r2['c_postal']  = $preinscripcion->c_postal;
                $r2['provincia'] = $preinscripcion->provincia;
                $r2['localidad'] = $preinscripcion->localidad;

                $miembro->responsable2_id = $miembro->guardaResponsable($r2);

                // Poner la función de familiar.
                $responsable2= Miembro::find($miembro->responsable2_id);

                $funcione_id = DB::table('funciones')->where('descripcion', 'familiar')->value('id');
                if ($responsable2->funciones()->where('descripcion', 'familiar')->count() == 0){
                    $responsable2->funciones()->attach($funcione_id, ['equipo_id' => null]);
                }
            }
        }

        // teléfono
        if (!is_null($preinscripcion->telefono)){
            $telefono = $miembro->telefonos()->create([
                'telefono' => $preinscripcion->telefono,
                'descripcion' => ''
            ]);
        }

        // email
        if (!is_null($preinscripcion->email)){
            $email = $miembro->emails()->create([
                'email' => $preinscripcion->email,
                'descripcion' => ''
            ]);
        }

        $miembro->save();

        //dd($miembro->id);
        return $miembro;
    }

    /* Devuelve los equipos en los que ha estado como jugador o entrenador, delegado en la temporada */
    public function equipoTemp($tempSel){
        $retorno = collect([]);

        foreach ($this->funciones as $funcion){
            $equipo = Equipo::find($funcion->pivot->equipo_id);
            $categoria = Categoria::find($equipo{'categoria_id'});
            $genero = Genero::find($equipo{'genero_id'});
            $temporada = Temporada::find($equipo{'temporada_id'});

            if (($funcion->descripcion != 'familiar') && ($temporada->id == $tempSel->id))  {
                $retorno->push([ 'id'=>$equipo->id,
                                 'equipo'=>$equipo->nombre,
                                 'categoria'=>$categoria->descripcion,
                                 'genero'=>$genero->descripcion,
                                 'funcion'=>$funcion->descripcion]);
            }
        }
        /* dd($retorno); */
        return $retorno;
    }

    /* Devuelve la preinscripcion de la temporada */
    public function preinscripcionTemp($temporada){
        return $this->preinscripciones->where('temporada_id', $temporada->id);
    }

    /* devuelve lo pagado durante la temporada y lo que debe pagar */
    public function pagosTemp($temporada){
        /* Se pone el total a pagar sólo si se ha preinscrito */
        $totalAPagar = 0;
        //dd($this->preinscripcionTemp($temporada)->first());
        if (!is_null($this->preinscripcionTemp($temporada)->first())){
            /* Se mira la categoría */
            $totalAPagar = $this->categoria($temporada->temporada)->precio_inscripcion;
        }
        return [$this->pagos->where('temporada_id', $temporada->id)->sum('importe'), $totalAPagar];

    }

    /* devuelve el importe de lo pagado en una temporada */
    /* NO ESTÁ PROBADA */
    public function pagado($temporada){
            return Pago::where('miembro_id', $this->id)->where('temporada_id', $temporada->id)->sum('importe');
        }

    /* devuelve el importe de lo que tiene que pagar en una temporada */
    public function aPagar($temporada){
        //dd($temporada->temporada);
        return $this->categoria($temporada->temporada)->precio_inscripcion;
    }

    /* Devuelve la lista de pagos deun mienbro por temporada */
    public function listaPagos($temporada){
        return $this->pagos->where('temporada_id', $temporada->id);
    }
}
