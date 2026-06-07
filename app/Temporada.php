<?php

namespace BMLaguna;

use Illuminate\Database\Eloquent\Model;

use BMLaguna\Equipo;
use BMLaguna\Equipacione;
use BMLaguna\Pago;
use BMLaguna\Preinscripcion;
use BMLaguna\Contador_recibo;
use BMLaguna\InformeFisicoTecnicoTactico;

class Temporada extends Model
{
    protected $fillable = ['temporada', 'descripcion'];

    public function equipos(){
        return $this->hasMany('BMLaguna\Equipo');
    }

    public function equipaciones(){
        return $this->hasMany('BMLaguna\Equipacione');
    }

    public function scopeActual($query){
        return $query->orderBy('temporada', 'desc')->first();
    }

    static public function Tactual(){
        return Temporada::orderBy('temporada', 'desc')->first();
    }

    public function siguienteAnio()
    {
        return $this->temporada + 1;
    }

    public function siguienteDescripcion()
    {
        $anio = $this->siguienteAnio();

        return $anio.'-'.($anio + 1);
    }

    public function conteoDatosVinculados()
    {
        return [
            'equipos' => Equipo::where('temporada_id', $this->id)->count(),
            'equipaciones' => Equipacione::where('temporada_id', $this->id)->count(),
            'pagos' => Pago::where('temporada_id', $this->id)->count(),
            'preinscripciones' => Preinscripcion::where('temporada_id', $this->id)->count(),
            'contador_recibos' => Contador_recibo::where('temporada_id', $this->id)->count(),
            'informes_ftt' => InformeFisicoTecnicoTactico::where('temporada_id', $this->id)->count(),
        ];
    }

    public function totalDatosVinculados()
    {
        return array_sum($this->conteoDatosVinculados());
    }
}
