<?php

namespace BMLaguna\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use BMLaguna\Funcione;
use BMLaguna\Miembro;
use BMLaguna\Genero;
use BMLaguna\Telefono;
use BMLaguna\Email;
use BMLaguna\Temporada;
use BMLaguna\Equipacione;
use BMLaguna\Categoria;


use BMLaguna\Http\Requests\StoreMiembroRequest;
use BMLaguna\Http\Requests\UpdateMiembroRequest;

class MiembroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Lista de temporadas
        $temporadas = Temporada::all()->sortBy('temporada');
        $tempActual_id = $request->get('temporada_id');

        if (is_null($tempActual_id)){
            $tempElegida = Temporada::Tactual();
        }
        else{
            $tempElegida = Temporada::find($tempActual_id);
        }

        // Lista de categorias
        $categorias = Categoria::all()->sortBy('orden');
        $catActual_id = $request->get('categoria_id');

        // Lista de generos
        $generos = Genero::all()->sortBy('descripcion');
        $genActual_id = $request->get('genero_id');

        // nombre
        $nombreBusqueda = $request->get('nombreBusqueda');

        // Criterios
        $miembros = Miembro::whereNull('f_baja');

        //Temporada
        if (!is_null($tempActual_id)){
            $miembros = $miembros->join('equipo_funcione_miembro', 'miembros.id', '=', 'equipo_funcione_miembro.miembro_id')->
                            join('equipos', 'equipos.id', '=', 'equipo_funcione_miembro.equipo_id')->
                            where('equipos.temporada_id', $tempActual_id)->
                            select('miembros.id', 'miembros.nombre', 'miembros.apellido1', 'miembros.apellido2', 'miembros.dorsal');
        }

        // Categoria
        if (!is_null($catActual_id)){
            $catElegida = Categoria::find($catActual_id);

            $miembros = $miembros->whereYear('f_nacimiento','>=', $catElegida->rangoAnnos($tempElegida)[0])->
                                whereYear('f_nacimiento','<=', $catElegida->rangoAnnos($tempElegida)[1]);
        }

        // Género
        if (!is_null($genActual_id)){
            $miembros = $miembros->where('miembros.genero_id', $genActual_id);
        }

        // Nombre
        if (!is_null($nombreBusqueda)){
            $miembros = $miembros->where(DB::raw("concat(miembros.nombre, ' ', miembros.apellido1, ' ', IFNULL(miembros.apellido2, ' '))"), "like",  "%$nombreBusqueda%");
        }

        $miembros = $miembros->
                    groupBy('miembros.id', 'miembros.nombre', 'miembros.apellido1', 'miembros.apellido2', 'miembros.dorsal')->
                    paginate(10);
        /* $miembros = $miembros->paginate(10);         */

        $vista = $request->get('vista');

        $textoBusqueda = $request->get('nombreBusqueda');
        $path = $request->url().'?temporada_id='.$tempActual_id.'&categoria_id='.$catActual_id.'&genero_id='.$genActual_id.'&nombreBusqueda='.$nombreBusqueda;
        
        if (!is_null($vista)){
            $path = $path.'&vista='.$vista;
        }
     //dd($miembros);   
        return view('miembros.index', compact('miembros', 'path', 'textoBusqueda', 'vista', 
                    'temporadas', 'tempActual_id', 
                    'categorias', 'catActual_id',
                    'generos', 'genActual_id',
                    'nombreBusqueda'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $funciones = Funcione::all();
        $responsables = Miembro::whereNull('f_nacimiento')->orWhere('f_nacimiento', '<', '2000/01/01')->get();
        $generos = Genero::where('descripcion', '!=', 'mixto')->get();

        // $dorsales = array();
        // array_push($dorsales, $miembro->dorsal);
        // $dorsales = array_merge($dorsales, $miembro->dorsales());

        $dorsales = range(1,99);
        
        return view('miembros.create', compact('funciones', 'generos', 'responsables', 'dorsales'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMiembroRequest $request)
    {
        //return $request->input('r1')['nombre'];

        $miembro = new Miembro();

        $miembro->nombre = $request->input('nombre');
        $miembro->apellido1 = $request->input('apellido1');
        $miembro->apellido2 = $request->input('apellido2');
        if (!is_null($request->input('f_nacimiento'))){
            $miembro->f_nacimiento = date('Y-m-d', strtotime($request->input('f_nacimiento')) );
        }
 
        if (!is_null($request->input('f_baja'))){
            $miembro->f_baja = date('Y-m-d', strtotime($request->input('f_baja')) );
        }

        $miembro->genero_id = $request->input('genero_id');
        $miembro->nif = $request->input('nif');
        $miembro->domicilio = $request->input('domicilio');
        $miembro->c_postal = $request->input('c_postal');
        $miembro->provincia = $request->input('provincia');
        $miembro->localidad = $request->input('localidad');

        $miembro->dorsal = $request->input('dorsal');
        $miembro->nSocio = $request->input('nSocio');
        $miembro->centroEducativo = $request->input('centroEducativo');
        $miembro->observaciones = $request->input('observaciones');
        $miembro->obserMedicas = $request->input('obserMedicas');

        // Añadir miembros responsables
        if ( is_null($request->input('responsable1_id')) && !is_null($request->input('r1')['nombre']) ){
            $r1 = $request->input('r1');
            $miembro->responsable1_id = $miembro->guardaResponsable($r1);
        }
        if (is_null($miembro->responsable1_id)){
            $miembro->responsable1_id = $request->input('responsable1_id');
        }

        if ( is_null($request->input('responsable2_id')) && !is_null($request->input('r2')['nombre']) ){
            $r2 = $request->input('r2');
            $miembro->responsable2_id = $miembro->guardaResponsable($r2);
        }

        if (is_null($miembro->responsable2_id)){
            $miembro->responsable2_id = $request->input('responsable2_id');
        }

        $miembro->save();
       
        // Asignar función de familiar
        if (!is_null($miembro->responsable1_id)){
            $responsable1= Miembro::find($miembro->responsable1_id);

            $funcione_id = DB::table('funciones')->where('descripcion', 'familiar')->value('id');  
            if ($responsable1->funciones()->where('descripcion', 'familiar')->count() == 0){
                $responsable1->funciones()->attach($funcione_id, ['equipo_id' => null]);
            }
        }

        if (!is_null($miembro->responsable2_id)){
            $responsable2= Miembro::find($miembro->responsable2_id);

            $funcione_id = DB::table('funciones')->where('descripcion', 'familiar')->value('id');    
            if ($responsable2->funciones()->where('descripcion', 'familiar')->count() == 0){
                $responsable2->funciones()->attach($funcione_id, ['equipo_id' => null]);
            }
        }

        // Guardar los datos de los teléfonos
        $telefonos = $request->input('telefonos');
        $descripciones = $request->input('descripciones');
        for ($i = 0; $i < count($telefonos); $i++){
            if (!is_null($telefonos[$i])){
                $telefono = $miembro->telefonos()->create([
                    'telefono' => $telefonos[$i],
                    'descripcion' => $descripciones[$i]
                ]);
            }
        }

        // Guardar los datos de los emails
        $emails = $request->input('emails');
        $desEmails = $request->input('desEmails');

        for ($i = 0; $i < count($emails); $i++ ){
            if (!is_null($emails[$i])){
                $email = $miembro->emails()->create([
                    'email' => $emails[$i],
                    'descripcion' => $desEmails[$i]
                ]);
            }
        }

        // Guardar foto
        $nombreArchivo ="";
         if ($request->hasFile('ruta')){
            $fichero = $request->file('ruta');
            $nombreArchivo = $miembro->id.'_'.time().'.jpg';
            $fichero->move(public_path().'/fotos/', $nombreArchivo);

            $documento_id = DB::table('documentos')->where('descripcion', 'foto')->value('id');

            $miembro->documentos()->attach($documento_id, ['ruta'=> $nombreArchivo, 'f_entrega' => date('Y/m/d')]);
        }

        // Guardar DNI Frontal
        $nombreArchivo ="";
         if ($request->hasFile('rutaDNIF')){
            $fichero = $request->file('rutaDNIF');
            $nombreArchivo = 'DNIF'.$miembro->id.'_'.time().'.jpg';
            $fichero->move(public_path().'/docs/', $nombreArchivo);

            $documento_id = DB::table('documentos')->where('descripcion', 'DNI Frontal')->value('id');

            $miembro->documentos()->attach($documento_id, ['ruta'=> $nombreArchivo, 'f_entrega' => date('Y/m/d'), 'f_caducidad' => date('Y-m-d', strtotime($request->input('f_caducidad')) )]);
        }

        // Guardar DNI Posterior
        $nombreArchivo ="";
         if ($request->hasFile('rutaDNIP')){
            $fichero = $request->file('rutaDNIP');
            $nombreArchivo = 'DNIP'.$miembro->id.'_'.time().'.jpg';
            $fichero->move(public_path().'/docs/', $nombreArchivo);

            $documento_id = DB::table('documentos')->where('descripcion', 'DNI Trasero')->value('id');

            $miembro->documentos()->attach($documento_id, ['ruta'=> $nombreArchivo, 'f_entrega' => date('Y/m/d'), 'f_caducidad' => date('Y-m-d', strtotime($request->input('f_caducidad')) )]);
        }

        return redirect()->route('miembros')->with('status', 'Miembro creado correctamente ');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Miembro $miembro)
    {
        $resp1 = new Miembro;
        $resp2 = new Miembro;
        $temporada = Temporada::TActual();
        
        if (!is_null($miembro->responsable1_id)){
            $resp1 = Miembro::find($miembro->responsable1_id);
        }

        if (!is_null($miembro->responsable2_id)){
            $resp2 = Miembro::find($miembro->responsable2_id);
        }

        $equipaciones = $temporada->equipaciones()->get();
        $equipacionesMiembro = $miembro->equipaciones()->get();

        return view('miembros.show', compact('miembro', 'resp1', 'resp2', 'equipaciones', 'equipacionesMiembro'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Miembro $miembro)
    {
        $funciones = Funcione::all();

        $responsables = Miembro::whereNull('f_nacimiento')->orWhere('f_nacimiento', '<', date('Y-m-d',strtotime(now()->subYears(18))) )->get();
        
        $generos = Genero::where('descripcion', '!=', 'mixto')->get();

        $telefonos = Telefono::where('miembro_id', $miembro->id)->get();
        $emails = Email::where('miembro_id', $miembro->id)->get();
        
        // if (!is_null($miembro->f_nacimiento)){
        //     $miembro->f_nacimiento = date('d/m/Y', strtotime($miembro->f_nacimiento));
        // }

        // if (!is_null($miembro->f_baja)){
        //     $miembro->f_baja = date('d-m-Y', strtotime($miembro->f_baja));
        // }

        $dorsales = array();
        array_push($dorsales, $miembro->dorsal);
        $dorsales = array_merge($dorsales, $miembro->dorsales());
        
        return view('miembros.edit', compact('funciones', 'generos', 'responsables', 'miembro', 'telefonos', 'emails', 'dorsales'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMiembroRequest $request, Miembro $miembro)
    {
        //return $request->input('r1')['nombre'];
        $miembro->fill($request->all());
        if (!is_null($request->input('f_nacimiento'))){
            $miembro->f_nacimiento = date('Y-m-d', strtotime($request->input('f_nacimiento')) );
        }
       
        if (!is_null($request->input('f_baja'))){
            $miembro->f_baja = date('Y-m-d', strtotime($request->input('f_baja')) );
        }

        // Añadir miembros responsables
        if ( is_null($request->input('responsable1_id')) && !is_null($request->input('r1')['nombre']) ){
            $r1 = $request->input('r1');
            $miembro->responsable1_id = $miembro->guardaResponsable($r1);
        }
        if (is_null($miembro->responsable1_id)){
            $miembro->responsable1_id = $request->input('responsable1_id');
        }

        if ( is_null($request->input('responsable2_id')) && !is_null($request->input('r2')['nombre']) ){
            $r2 = $request->input('r2');
            $miembro->responsable2_id = $miembro->guardaResponsable($r2);
        }

        if (is_null($miembro->responsable2_id)){
            $miembro->responsable2_id = $request->input('responsable2_id');
        }

        $miembro->save();

        // Asignar función de familiar
        if (!is_null($miembro->responsable1_id)){
            $responsable1= Miembro::find($miembro->responsable1_id);

            $funcione_id = DB::table('funciones')->where('descripcion', 'familiar')->value('id');  
            if ($responsable1->funciones()->where('descripcion', 'familiar')->count() == 0){
                $responsable1->funciones()->attach($funcione_id, ['equipo_id' => null]);
            }
        }

        if (!is_null($miembro->responsable2_id)){
            $responsable2= Miembro::find($miembro->responsable2_id);

            $funcione_id = DB::table('funciones')->where('descripcion', 'familiar')->value('id');    

            if ($responsable2->funciones()->where('descripcion', 'familiar')->count() == 0){
                $responsable2->funciones()->attach($funcione_id, ['equipo_id' => null]);
            }
        }
        
        // Foto
        $nombreArchivo ="";
         if ($request->hasFile('ruta')){
            $fichero = $request->file('ruta');
            $nombreArchivo = $miembro->id.'_'.time().'.jpg';
            $fichero->move(public_path().'/fotos/', $nombreArchivo);

            $documento_id = DB::table('documentos')->where('descripcion', 'foto')->value('id');

            $miembro->documentos()->attach($documento_id, ['ruta'=> $nombreArchivo, 'f_entrega' => date('Y/m/d')]);
        }

        // DNI Frontal
        $nombreArchivo ="";
         if ($request->hasFile('rutaDNIF')){
            $fichero = $request->file('rutaDNIF');
            $nombreArchivo = 'DNIF'.$miembro->id.'_'.time().'.jpg';
            $fichero->move(public_path().'/docs/', $nombreArchivo);

            $documento_id = DB::table('documentos')->where('descripcion', 'DNI Frontal')->value('id');

            $miembro->documentos()->attach($documento_id, ['ruta'=> $nombreArchivo, 'f_entrega' => date('Y/m/d'), 'f_caducidad' => date('Y-m-d', strtotime($request->input('f_caducidad')) ) ]);
        }

        // DNI Posterior
        $nombreArchivo ="";
         if ($request->hasFile('rutaDNIP')){
            $fichero = $request->file('rutaDNIP');
            $nombreArchivo = 'DNIP'.$miembro->id.'_'.time().'.jpg';
            $fichero->move(public_path().'/docs/', $nombreArchivo);

            $documento_id = DB::table('documentos')->where('descripcion', 'DNI Trasero')->value('id');

            $miembro->documentos()->attach($documento_id, ['ruta'=> $nombreArchivo, 'f_entrega' => date('Y/m/d'), 'f_caducidad' => date('Y-m-d', strtotime($request->input('f_caducidad')) ) ]);
        }

        // Borramos los actuales Teléfonos
        DB::table('telefonos')->where('miembro_id', $miembro->id)->delete();

        // Guardamos los teléfonos
        $telefonos = $request->input('telefonos');
        $descripciones = $request->input('descripciones');
        for ($i = 0; $i < count($telefonos); $i++){
            if (!is_null($telefonos[$i])){
                $telefono = $miembro->telefonos()->updateOrCreate([
                    'telefono' => $telefonos[$i],
                    'descripcion' => $descripciones[$i]
                ]);

            }
        }
        
        // Borramos los actuales emails
        DB::table('emails')->where('miembro_id', $miembro->id)->delete();

        // Guardamos los emails
        $emails = $request->input('emails');
        $desEmails = $request->input('desEmails');
        for ($i = 0; $i < count($emails); $i++){
            if (!is_null($emails[$i])){
                $email = $miembro->emails()->updateOrCreate([
                    'email' => $emails[$i],
                    'descripcion' => $desEmails[$i]
                    ]);
            }
        }

        return redirect()->route('miembros')->with('status', 'Miembro actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Miembro $miembro)
    {
        $miembro->borrar();

        return redirect()->route('miembros')->with('status', 'Miembro borrado correctamente');
    }

    public function equipacionesMiembro($miembro_id){
        
        $miembro = Miembro::find($miembro_id);
        $equipaciones = Equipacione::where('temporada_id', Temporada::Tactual()->id)->get();

        return view('miembros.equipacionesMiembro', compact('miembro', 'equipaciones'));
    }

}
