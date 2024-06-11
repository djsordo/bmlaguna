<?php

namespace BMLaguna;

use Illuminate\Database\Eloquent\Model;

use BMLaguna\Pago;

class Tipospago extends Model

{
    protected $fillable = ['descripcion', 'modalidad'];

    public function pagos(){
        return $this->hasMany('BMLaguna\Pago');
    }
}
