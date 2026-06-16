<?php

namespace BMLaguna;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use BMLaguna\Tipospago;
use BMLaguna\Miembro;
use BMLaguna\Temporada;

class Pago extends Model
{
    const ESTADO_PENDIENTE = 'Pendiente';
    const ESTADO_PAGADO = 'Pagado';

    protected $fillable = ['miembro_id', 'f_pago', 'f_vencimiento', 'importe', 'tipospago_id', 'temporada_id', 'nRecibo', 'estado'];

    /**
     * Pagos efectivamente cobrados (f_pago informado). Sin fecha = pendiente, no cuenta como pagado.
     */
    public function scopeRealizados($query)
    {
        return $query->whereNotNull('f_pago');
    }

    public function scopePendientes($query)
    {
        return $query->whereNull('f_pago');
    }

    public function esRealizado()
    {
        return $this->estado === self::ESTADO_PAGADO
            || ($this->f_pago !== null && $this->f_pago !== '');
    }

    public function marcarComoPagado($fecha = null)
    {
        $this->f_pago = $fecha ?: date('Y-m-d');
        $this->estado = self::ESTADO_PAGADO;
    }

    public function marcarComoPendiente()
    {
        $this->f_pago = null;
        $this->estado = self::ESTADO_PENDIENTE;
    }

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
        return DB::table('pagos')
                ->where('miembro_id', $this->miembro_id)
                ->where('temporada_id', $this->temporada_id)
                ->whereNotNull('f_pago')
                ->sum('importe');
    }

    /* Esta función suma los pagos hasta el mismo del miembro en la temporada */
    public function sumPagadoParcial(){
        $q = DB::table('pagos')
            ->where('miembro_id', $this->miembro_id)
            ->where('temporada_id', $this->temporada_id)
            ->whereNotNull('f_pago')
            ->where('id', '<=', $this->id);

        if ($this->f_pago !== null) {
            $q->where('f_pago', '<=', $this->f_pago);
        }

        return $q->sum('importe');
    }
}
