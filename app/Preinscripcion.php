<?php

namespace BMLaguna;

use BMLaguna\Genero;
use BMLaguna\Miembro;
use BMLaguna\Temporada;

use Illuminate\Database\Eloquent\Model;

class Preinscripcion extends Model
{
    protected $fillable = ['nif', 'f_nacimiento', 'genero_id', 'nombre', 'apellido1', 'apellido2', 'centroEducativo','domicilio', 'c_postal', 'localidad', 'provincia', 'nombreR1', 'apellido1R1', 'apellido2R1', 'nombreR2', 'apellido1R2', 'apellido2R2', 'telefono', 'email', 'miembro_id', 'temporada_id', 'estado', 'f_preinscripcion', 'f_pago', 'nPreinscripcion', 'socio', 'nRecibo'];

    public function genero(){
        return $this->belongsTo('BMLaguna\Genero');
    }

    public function miembro(){
        return $this->belongsTo('BMLaguna\Miembro');
    }

    public function temporada(){
        return $this->belongsTo('BMLaguna\Temporada');
    }

 
}
