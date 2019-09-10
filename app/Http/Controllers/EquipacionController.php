<?php

namespace BMLaguna\Http\Controllers;

use Illuminate\Http\Request;

use BMLaguna\Temporada;
use BMLaguna\Talla;
use BMLaguna\Equipacione;

use BMLaguna\Http\Requests\StoreEquipacioneRequest;
use BMLaguna\Http\Requests\UpdateEquipacioneRequest;

class EquipacionController extends Controller
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

        $tempActual = Temporada::Tactual();
        $equipaciones = Equipacione::where('temporada_id', $tempActual_id)->get();

        return view('equipaciones.index', compact('equipaciones', 'temporadas', 'tempActual_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $temporadas = Temporada::orderBy('temporada', 'desc')->get();
        $tempActual = Temporada::Tactual();
        $tallas = Talla::all();

        return view('equipaciones.create', compact('temporadas', 'tempActual', 'tallas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEquipacioneRequest $request)
    {
        //  dd($request->hasFile('rutaImagen'));
        $equipacion = new Equipacione();

        $equipacion->descripcion = $request->input('descripcion');
        $equipacion->temporada_id = $request->input('temporada_id');
        $equipacion->marca = $request->input('marca');

        $equipacion->save();

        // Archivo
        $nombreArchivo ="";
        
        if ($request->hasFile('rutaImagen')){
            $fichero = $request->file('rutaImagen');
            $extension = $fichero->extension();

            $nombreArchivo = $equipacion->id.'_EQUIP_'.time().'.'.$extension;
            $fichero->move(public_path().'/images/', $nombreArchivo);

            $equipacion->rutaImagen = $nombreArchivo;
        }
        
        $equipacion->save();

        // Tallas
        if (!is_null($request->input('tallas_id'))){
            foreach($request->input('tallas_id') as $talla_id){
                $equipacion->tallas()->attach($talla_id);
            }
        }
        
        return redirect()->route('equipaciones')->with('status', 'Equipación creada correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Equipacione $equipacione)
    {
        // dd($equipacione);
        $temporadas = Temporada::orderBy('temporada', 'desc')->get();
        $tempActual = Temporada::Tactual();
        $tallas = Talla::all();
        $tallasElegidas = $equipacione->tallas()->get();

        return view('equipaciones.edit', compact('equipacione', 'temporadas', 'tempActual', 'tallas', 'tallasElegidas'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEquipacioneRequest $request, Equipacione $equipacione)
    {
        // dd($request);
        $equipacione->descripcion = $request->input('descripcion');
        $equipacione->temporada_id = $request->input('temporada_id');
        $equipacione->marca = $request->input('marca');

     
        // $ruta = '/images/'.$equipacione->id.'_*';
        // unlink(public_path($ruta));

        // Archivo
        $nombreArchivo ="";
                
        if ($request->hasFile('rutaImagen')){
            // Recupero la ruta de la bae de datos para borrar la imagen obsoleta
            $rutaAnt = Equipacione::find($equipacione->id)->rutaImagen;
            if (!is_null($rutaAnt)){
                unlink(public_path('/images/'.$rutaAnt));
            }

            $fichero = $request->file('rutaImagen');
            $extension = $fichero->extension();

            $nombreArchivo = $equipacione->id.'_EQUIP_'.time().'.'.$extension;
            $fichero->move(public_path().'/images/', $nombreArchivo);

            $equipacione->rutaImagen = $nombreArchivo;
        }

        // Tallas
        $equipacione->tallas()->detach();
        
        if (!is_null($request->input('tallas_id'))){
            foreach($request->input('tallas_id') as $talla_id){
                $equipacione->tallas()->attach($talla_id);
            }
        }
        


        $equipacione->save();

        

        return redirect()->route('equipaciones')->with('status', 'Equipación actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
