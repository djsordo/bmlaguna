<?php

namespace BMLaguna;

use Illuminate\Database\Eloquent\Model;
use BMLaguna\Talla;
use BMLaguna\Miembro;

class Equipacione extends Model
{
    protected $fillable = ['temporada_id', 'marca', 'descripcion', 'rutaImagen'];

    public function tallas(){
        return $this->belongsToMany('BMLaguna\Talla');
    }

    public function miembros(){
        return $this->belongsToMany('BMLaguna\Miembro');
    }
}
