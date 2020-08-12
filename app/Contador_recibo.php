<?php

namespace BMLaguna;
use BMLaguna\Temporada;

use Illuminate\Database\Eloquent\Model;

class Contador_recibo extends Model
{
    protected $fillable = ['temporada_id', 'nRecibo'];

    public function temporada(){
        return $this->belongsTo('BMLaguna\Temporada');
    }

    // Esta función incrementa el contador de número de recibo de la temporada dada
    static public function sumar(Temporada $temporada){
        $cRecibo = Contador_recibo::where('temporada_id',$temporada->id)->first();

        if (is_null($cRecibo)){
            $cRecibo = new Contador_recibo();
            $cRecibo->temporada_id = $temporada->id;
            $cRecibo->nRecibo = 1;
            $cRecibo->save();
        }
        else{
            $cRecibo->nRecibo = $cRecibo->nRecibo +1;
            $cRecibo->save();
        }

        return $cRecibo->nRecibo;
    }
}
