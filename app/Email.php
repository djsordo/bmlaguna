<?php

namespace BMLaguna;

use Illuminate\Database\Eloquent\Model;
use BMLaguna\Miembro;

class Email extends Model
{
    protected $fillable = ['miembro_id', 'email', 'descripcion'];

    public function miembro(){
        return $this->belongsTo('BMLaguna\Miembro');
    }

}
