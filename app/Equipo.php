<?php

namespace BMLaguna;

use Illuminate\Database\Eloquent\Model;
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
        $oficiales_id = Funcione::whereIn('descripcion', Funcione::rolesOficialEquipo())->pluck('id');
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

        $jugadorId = Funcione::where('descripcion', 'jugador')->value('id');
        if (! $jugadorId) {
            return collect();
        }

        // Misma temporada: solo excluir si ya está como jugador en algún equipo (no por otros roles: técnico, etc.).
        return Miembro::whereYear('f_nacimiento', '>', $fDesde)
            ->whereYear('f_nacimiento', '<=', $fHasta)
            ->whereNull('f_baja')
            ->whereIn('genero_id', $genero)
            ->whereDoesntHave('equipos', function ($query) use ($jugadorId) {
                $query->where('temporada_id', $this->temporada_id)
                    ->where('equipo_funcione_miembro.funcione_id', $jugadorId);
            })
            ->get();
    }

    public function oficialesPosibles(){
        $idTecnico = Funcione::where('descripcion', Funcione::DESC_TECNICO)->value('id');

        if (! $idTecnico) {
            return collect();
        }

        return Miembro::whereNull('f_baja')
            ->whereHas('funcionesClub', function ($q) use ($idTecnico) {
                $q->where('funcione_id', $idTecnico);
            })
            ->get()
            ->diff($this->oficiales);
    }

    public function scopePorTemporada($query, $temporada){
        return $query->where('temporada_id', $temporada);
    }
}
