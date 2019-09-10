<?php

namespace BMLaguna;

use Illuminate\Database\Eloquent\Model;
use BMLaguna\Equipacione;

class Talla extends Model
{
    protected $fillable = ['descripcion'];

    public function equipaciones(){
        return $this->belongsToMany('BMLaguna\Equipacione');
    }
}
