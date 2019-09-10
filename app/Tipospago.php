<?php

namespace BMLaguna;

use Illuminate\Database\Eloquent\Model;

use BMLaguna\Pago;

class Tipospago extends Model

{
    protected $fillable = ['descripcion'];

    public function pagos(){
        return $this->hasMany('BMLaguna\Pago');
    }
}
