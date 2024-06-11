<?php

namespace BMLaguna;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use BMLaguna\Tipospago;
use BMLaguna\Miembro;
use BMLaguna\Temporada;

class Pago extends Model
{
    protected $fillable = ['miembro_id', 'f_pago', 'f_vencimiento', 'importe', 'tipospago_id', 'temporada_id', 'nRecibo', 'estado'];

    public function tipospago(){
        return $this->belongsTo('BMLaguna\Tipospago');
    }

    public function miembro(){
        return $this->belongsTo('BMLaguna\Miembro');
    }

    public function temporada(){
        return $this->belongsTo('BMLaguna\Temporada');
    }

    /* Esta función suma los pagos totales del miembro en la temporada */
    public function sumPagado(){
        //dd($this);
        return DB::table('pagos')
                ->where ('pagos.miembro_id', $this->miembro_id)
                ->where ('pagos.temporada_id', $this->temporada_id)
                ->where ('pagos.estado', 'Pagado')
                ->join ('tipospagos', 'tipospagos.id', '=', 'pagos.tipospago_id')
                ->where ('tipospagos.modalidad', '!=', null )
                ->sum('pagos.importe');
    }

    /* Esta función suma los pagos hasta el mismo del miembro en la temporada */
    public function sumPagadoParcial(){
        //dd($this);
        return DB::table('pagos')
                ->where ('miembro_id', $this->miembro_id)
                ->where ('temporada_id', $this->temporada_id)
                //->where ('f_pago', '<=', $this->f_pago)
                ->where ('id', '<=', $this->id)
                ->sum('importe');
    }
}
