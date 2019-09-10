<?php

namespace BMLaguna;

use Illuminate\Database\Eloquent\Model;

use BMLaguna\Equipo;
use BMLaguna\Equipacione;

class Temporada extends Model
{
    protected $fillable = ['temporada', 'descripcion'];

    public function equipos(){
        return $this->hasMany('BMLaguna\Equipo');
    }

    public function equipaciones(){
        return $this->hasMany('BMLaguna\Equipacione');
    }

    public function scopeActual($query){
        return $query->orderBy('temporada', 'desc')->first();
    }

    static public function Tactual(){
        return Temporada::orderBy('temporada', 'desc')->first();
    }

    
}
