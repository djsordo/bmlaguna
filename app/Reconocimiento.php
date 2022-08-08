<?php

namespace BMLaguna;

use BMLaguna\Miembro;
use BMLaguna\Temporada;

use Illuminate\Database\Eloquent\Model;

class Reconocimiento extends Model
{
    protected $fillable = ['miembro_id', 'temporada_id', 'f_reconocimiento', 'peso', 'talla', 'tensionH', 'tensionL', 'saturacion', 'FC', 'FCPEST', 'medicacion', 'oido', 'vista', 'columna', 'ACA', 'observaciones'];

    public function miembro(){
        return $this->belongsTo('BMLaguna\Miembro');
    }

    public function temporada(){
        return $this->belongsTo('BMLaguna\Temporada');
    }

}
