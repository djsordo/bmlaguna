<?php

namespace BMLaguna;

use Illuminate\Database\Eloquent\Model;
use BMLaguna\Miembro;

class Documento extends Model
{
    protected $fillable = ['tipo', 'subTipo', 'descripcion'];

    public function miembros(){
        return $this->belongsToMany('BMLaguna\Miembro')->withPivot('ruta', 'f_entrega', 'f_caducidad');
    }

}

