<?php

namespace BMLaguna;

use Illuminate\Database\Eloquent\Model;

class Reconocimiento extends Model
{
    protected $fillable = ['miembro_id', 'temporada_id', 'f_reconocimiento', 'peso', 'talla', 'tensionH', 'tensionL', 'saturacion', 'FC', 'FC-PEST', 'medicacion', 'oido', 'vista', 'columna', 'ACA'];
}
