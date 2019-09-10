<?php

namespace BMLaguna;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use BMLaguna\Categoria;
use BMLaguna\Genero;
use BMLaguna\Funcione;
use BMLaguna\Miembro;
use BMLaguna\Temporada;

class Equipo extends Model
{
    protected $fillable = ['temporada_id', 'nombre', 'categoria_id', 'genero_id'];

    public function categoria(){
        return $this->belongsTo('BMLaguna\Categoria');
    }

    public function genero(){
        return $this->belongsTo('BMLaguna\Genero');
    }

    public function temporada(){
        return $this->belongsTo('BMLaguna\Temporada');
    }

    public function funciones(){
        return $this->belongsToMany('BMLaguna\Funcione', 'equipo_funcione_miembro')->withPivot('miembro_id');
    }

    public function miembros(){
        return $this->belongsToMany('BMLaguna\Miembro', 'equipo_funcione_miembro')->withPivot('funcione_id');
    }

    public function jugadores(){
        $jugador_id = Funcione::where('descripcion', 'jugador')->value('id');
        return $this->belongsToMany('BMLaguna\Miembro', 'equipo_funcione_miembro')
                    ->withPivot('funcione_id')
                    ->wherePivot('funcione_id', $jugador_id);
    }

    public function oficiales(){
        $oficiales_id = Funcione::whereIn('descripcion', ['entrenador', 'delegado'])->select('id')->get();
        return $this->belongsToMany('BMLaguna\Miembro', 'equipo_funcione_miembro')
                    ->withPivot('funcione_id')
                    ->wherePivotIn('funcione_id', $oficiales_id);
    }

    public function jugadoresPosibles(){
        $fDesde = $this->temporada->temporada - ($this->categoria->edad + $this->categoria->duracion);
        $fHasta = $this->temporada->temporada - $this->categoria->edad;



        $masculino_id = Genero::where('descripcion', 'masculino')->value('id');
        $femenino_id = Genero::where('descripcion', 'femenino')->value('id');

        if ($this->genero->descripcion == 'masculino'){
            $genero = [$masculino_id];
        }
        elseif ($this->genero->descripcion == 'femenino'){
            $genero = [$femenino_id];
        }
        elseif ($this->genero->descripcion == 'mixto'){
            $genero = [$masculino_id, $femenino_id];
        }

        // Sacamos los jugadores válidos para el equipo (Edades en los límites de la categoría, que no tengan otro equipo en la misma temporada)
        return Miembro::whereYear('f_nacimiento', '>', $fDesde)
                                    ->whereYear('f_nacimiento', '<=', $fHasta)
                                    ->whereNull('f_baja')
                                    ->whereIn('genero_id', $genero)
                                    ->whereDoesntHave('equipos', function ($query){
                                        $query->where('temporada_id', $this->temporada_id);
                                    })
                                    ->get();
    }

    public function oficialesPosibles(){
        $f_mayoria = Carbon::now()->subYears(16)->format('Y-m-d');

        // Sacamos los oficiales válidos para el equipo (mayores de 16 años), que no esten ya en el equipo de oficiales.
        return Miembro::where('f_nacimiento', '<', $f_mayoria)
                        ->whereNull('f_baja')
                                    ->get()->diff($this->oficiales);

    }

    public function scopePorTemporada($query, $temporada){
        return $query->where('temporada_id', $temporada);
    }
}
