<?php

namespace BMLaguna;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use BMLaguna\Tipospago;
use BMLaguna\Miembro;
use BMLaguna\Temporada;

class Pago extends Model
{
    protected $fillable = ['miembro_id', 'f_pago', 'importe', 'tipospago_id', 'temporada_id'];
  
    public function tipospago(){
        return $this->belongsTo('BMLaguna\Tipospago');
    }

    public function miembro(){
        return $this->belongsTo('BMLaguna\Miembro');
    }

    public function temporada(){
        return $this->belongsTo('BMLaguna\Temporada');
    }

    /* Esta función suma los pagos del miembro en la temporada */
    public function sumPagado(){
        //dd($this);
        return DB::table('pagos')
                ->where ('miembro_id', $this->miembro_id)
                ->where ('temporada_id', $this->temporada_id)
                ->sum('importe');
    }

}
