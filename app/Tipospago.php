<?php

namespace BMLaguna;

use Illuminate\Database\Eloquent\Model;

use BMLaguna\Pago;

class Tipospago extends Model

{
    protected $table = 'tipospagos';

    protected $fillable = ['descripcion', 'modalidad'];

    public function pagos(){
        return $this->hasMany('BMLaguna\Pago');
    }

    /**
     * Tipos de pago de inscripción por modalidad (1, 2 o 3 plazos), ordenados por id.
     */
    public static function tiposPorModalidad($modalidad)
    {
        return static::where('modalidad', (int) $modalidad)
            ->where('modalidad', '>', 0)
            ->orderBy('id')
            ->get();
    }
}
