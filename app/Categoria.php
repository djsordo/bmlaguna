<?php

namespace BMLaguna;

use Illuminate\Database\Eloquent\Model;
use BMLaguna\Equipo;
use BMLaguna\Miembro;

class Categoria extends Model
{
    protected $fillable = [ 'descripcion',
                            'edad',
                            'duracion',
                            'precio_inscripcion',
                            'precio_inscripcion2c',
                            'precio_inscripcion3c',
                            'precio_2c1',
                            'precio_2c2',
                            'precio_3c1',
                            'precio_3c2',
                            'precio_3c3',
                            'orden'];

    public function equipos(){
        return $this->hasMany('BMLaguna\Equipo');
    }

    // Buscamos los jugadores por categoría, estén en un equipo o no.
    public function miembros($temporada){
        $miembros = Miembro::all();

        $i = 0;
        foreach($miembros as $miembro){
            if ($miembro->categoria($temporada->temporada)->id != $this->id){
                $miembros->pull($i);
            }
            $i++;
        }

        return $miembros->values();
    }

    public function masculinos($temporada){
        $genero = Genero::where('descripcion', 'masculino')->first();
        $miembros = Miembro::where('genero_id', $genero->id)->get();

        $i = 0;
        foreach($miembros as $miembro){
            if ($miembro->categoria($temporada->temporada)->id != $this->id) {
                $miembros->pull($i);
            }
            $i++;
        }

        return $miembros->values();
    }

    public function femeninos($temporada){
        $genero = Genero::where('descripcion', 'femenino')->first();
        $miembros = Miembro::where('genero_id', $genero->id)->get();

        $i = 0;
        foreach($miembros as $miembro){
            if ($miembro->categoria($temporada->temporada)->id != $this->id) {
                $miembros->pull($i);
            }
            $i++;
        }

        return $miembros->values();
    }

    // esta función devuelve un array con los dorsales usados en la categoría, según el género
    public function dorsales($genero){
        if ($genero == "femenino"){
            $miembros = $this->femeninos(Temporada::actual());
        }
        elseif ($genero == "masculino"){
            $miembros = $this->masculinos(Temporada::actual());
        }

        $dorsales = array();

        foreach ($miembros as $miembro){
            array_push($dorsales,$miembro->dorsal);
        }

        return $dorsales;
    }

    // Esta función devuelve la categoría anterior a la actual y, si no existiera, devuelve NULL
    public function anterior(){
        $categorias = Categoria::orderBy('orden', 'DESC')->get();

        $anterior = null;
        foreach ($categorias as $categoria){
            if ($this != $categoria){
                $anterior = $categoria;
            }
            else{
                break;
            }
        }

        return $anterior;
    }

    // Esta función devuelve la categoría siguiente a la actual y, si no existiera, devuelve NULL
    public function siguiente(){
        $categorias = Categoria::orderBy('orden', 'ASC')->get();

        $siguientes = null;
        foreach ($categorias as $categoria){
            if ($this != $categoria){
                $siguientes = $categoria;
            }
            else{
                break;
            }
        }

        return $siguientes;
    }

    // Esta función devuelve los preinscritos de una categoría según el genero
    public function preinscritos($genero){
        if ($genero == "femenino"){
            $miembros = $this->femeninos(Temporada::actual());
        }
        elseif ($genero == "masculino"){
            $miembros = $this->masculinos(Temporada::actual());
        }

        $i = 0;

        foreach($miembros as $miembro){
            if (!$miembro->preinscrito()) {
                $miembros->pull($i);
            }
            $i++;
        }
        // dd($miembros);
        return $miembros->values();
    }

    // Esta función devuelve los probados de una categoría según el genero
    public function probados($genero){
        if ($genero == "femenino"){
            $miembros = $this->femeninos(Temporada::actual());
        }
        elseif ($genero == "masculino"){
            $miembros = $this->masculinos(Temporada::actual());
        }

        $i = 0;

        foreach($miembros as $miembro){
            if (!$miembro->probado()) {
                $miembros->pull($i);
            }
            $i++;
        }
        // dd($miembros);
        return $miembros->values();
    }

    // Esta función devuelve el rago de fechas de nacimiento de la categoría según la temporada.
    public function rangoAnnos($temporada){
        $annoPrimero = $temporada->temporada - ($this->edad + ($this->duracion -1));
        $annoUltimo = $temporada->temporada - $this->edad;

        return [$annoPrimero, $annoUltimo];
    }

}
