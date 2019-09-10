<?php

namespace BMLaguna;

use Illuminate\Database\Eloquent\Model;
use BMLaguna\Miembro;
use BMLaguna\Equipo;

class Funcione extends Model
{
    public function miembros(){
        return $this->belongsToMany('BMLaguna\Miembro', 'equipo_funcione_miembro')->withPivot('equipo_id');
    }

    public function equipos(){
        return $this->belongsToMany('BMLaguna\Equipo', 'equipo_funcione_miembro')->withPivot('miembro_id');
    }

}
