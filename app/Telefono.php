<?php

namespace BMLaguna;

use Illuminate\Database\Eloquent\Model;
use BMLaguna\Miembro;

class Telefono extends Model
{
    protected $fillable = ['miembro_id', 'telefono', 'descripcion'];

    public function miembro(){
        return $this->belongsTo('BMLaguna\Miembro');
    }
}
