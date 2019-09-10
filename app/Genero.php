<?php

namespace BMLaguna;

use Illuminate\Database\Eloquent\Model;
use BMLaguna\Equipo;

class Genero extends Model
{
    public function equipos(){
        return $this->hasMany('BMLaguna\Equipo');
    }

}
