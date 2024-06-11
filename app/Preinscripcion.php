<?php

namespace BMLaguna;

use BMLaguna\Genero;
use BMLaguna\Miembro;
use BMLaguna\Temporada;
use BMLaguna\Categoria;
use stdClass;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Preinscripcion extends Model
{
    protected $fillable = ['nif', 'f_nacimiento', 'genero_id', 'nombre', 'apellido1', 'apellido2',
                'centroEducativo','domicilio', 'c_postal', 'localidad', 'provincia', 'nombreR1',
                'apellido1R1', 'apellido2R1', 'nombreR2', 'apellido1R2', 'apellido2R2', 'telefono',
                'telefonoFijo', 'telefonoOtro', 'email', 'obsEnfermedad', 'obsAlergia', 'obsOtras',
                'miembro_id', 'temporada_id', 'estado', 'f_preinscripcion', 'f_pago', 'importePago',
                'nPreinscripcion', 'socio', 'autorizacion', 'normas', 'nRecibo', 'nomSerigrafia', 'dorsal', 'modalidad_pago'];

    public function genero(){
        return $this->belongsTo('BMLaguna\Genero');
    }

    public function miembro(){
        return $this->belongsTo('BMLaguna\Miembro');
    }

    public function temporada(){
        return $this->belongsTo('BMLaguna\Temporada');
    }

     // Esta función devuelve la cuota correspondiente al año de nacimiento.
     public function cuota(){
        // Cogemos el año de nacimiento
        $aNacimiento = Carbon::parse($this->f_nacimiento)->year;
        $edad = Temporada::Tactual()->temporada - $aNacimiento;

        $categorias = Categoria::orderBy('edad', 'ASC')->get();

        foreach ($categorias as $categoria){
            if ($edad >= $categoria->edad &&
               $edad < $categoria->edad+$categoria->duracion) {
                $cuota = new stdClass();
                $cuota->precio_inscripcion = $categoria->precio_inscripcion;
                $cuota->precio_inscripcion2c = $categoria->precio_inscripcion2c;
                $cuota->precio_inscripcion3c = $categoria->precio_inscripcion3c;
                $cuota->precio_2c1 = $categoria->precio_2c1;
                $cuota->precio_2c2 = $categoria->precio_2c2;
                $cuota->precio_3c1 = $categoria->precio_3c1;
                $cuota->precio_3c2 = $categoria->precio_3c2;
                $cuota->precio_3c3 = $categoria->precio_3c3;
                $cuota->f_plazo_insc = $categoria->f_plazo_insc;
                $cuota->f_plazo_2c1 = $categoria->f_plazo_2c1;
                $cuota->f_plazo_2c2 = $categoria->f_plazo_2c2;
                $cuota->f_plazo_3c1 = $categoria->f_plazo_3c1;
                $cuota->f_plazo_3c2 = $categoria->f_plazo_3c2;
                $cuota->f_plazo_3c3 = $categoria->f_plazo_3c3;
            }
        }

        //dd($cuota);
        return $cuota;
    }
}
