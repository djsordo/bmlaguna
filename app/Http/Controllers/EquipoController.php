<?php

namespace BMLaguna\Http\Controllers;

use Illuminate\Http\Request;
use BMLaguna\Equipo;
use BMLaguna\Categoria;
use BMLaguna\Genero;
use BMLaguna\Miembro;
use BMLaguna\Funcione;
use BMLaguna\Temporada;

use BMLaguna\Http\Requests\StoreEquipoRequest;
use BMLaguna\Http\Requests\UpdateEquipoRequest;

class EquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $temporadas = Temporada::all();

        if ($request->get('temporada_id') == '') {
            $tempActual_id = Temporada::actual()->id;
        }
        else{
            $tempActual_id = $request->get('temporada_id');
        }

        $equipos = Equipo::porTemporada($tempActual_id)->withCount(['jugadores', 'oficiales'])->get();
        $categorias = Categoria::orderBy('orden')->get();
        $generos = Genero::all();

        return view('equipos.index', compact('equipos', 'temporadas', 'tempActual_id', 'categorias', 'generos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = Categoria::all();
        $generos = Genero::all();
        $temporadas = Temporada::all();
        
        return view('equipos.create', compact('categorias', 'generos', 'temporadas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEquipoRequest $request)
    {
        $equipo = new Equipo();

        $equipo->nombre = $request->input('nombre');
        $equipo->temporada_id = $request->input('temporada_id');
        $equipo->categoria_id = $request->input('categoria_id');
        $equipo->genero_id = $request->input('genero_id');

        $equipo->save();

        return redirect()->route('equipos')->with('status', 'Equipo creado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Equipo $equipo)
    {

        return view('equipos.show', compact('equipo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Equipo $equipo)
    {
        $categorias = Categoria::all();
        $generos = Genero::all();
        $temporadas = Temporada::all();

        return view('equipos.edit', compact('equipo', 'categorias', 'generos', 'temporadas')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEquipoRequest $request, Equipo $equipo)
    {
        $equipo->fill($request->all());
        $equipo->save();

        return redirect()->route('equipos')->with('status', 'Equipo actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Equipo $equipo)
    {
        $equipo->delete();
        return redirect()->route('equipos')->with('status', 'Equipo borrado correctamente');
    }

    public function asignar($equipo_id, $miembro_id, $tipo){
        $funcion = Funcione::where('descripcion',$tipo)->first();
        $equipo = Equipo::find($equipo_id);
        $equipo->miembros()->attach($miembro_id, ['funcione_id' => $funcion->id]);
      
        return redirect()->route('equipos.show', $equipo_id);
    }

    public function deasignar($equipo_id, $miembro_id, $tipo){
        $funcion = Funcione::where('descripcion',$tipo)->first();
        $equipo = Equipo::find($equipo_id);

        $equipo->miembros()->wherePivot('miembro_id', $miembro_id)
                           ->wherePivot('funcione_id', $funcion->id)->detach();

        return redirect()->route('equipos.show', $equipo_id);
    }

}


