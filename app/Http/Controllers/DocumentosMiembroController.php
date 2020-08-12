<?php

namespace BMLaguna\Http\Controllers;

use Illuminate\Http\Request;

use BMLaguna\Miembro;
use BMLaguna\Documento;

class DocumentosMiembroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Mostramos todos los documentos que pertenezcan a un miembro
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Aquí se crea un nuevo documento para el miembro dado
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->hasFile('ruta'));
        //Aquí se guarda el documento creado para el miembro
        $miembro = Miembro::find($request->miembro_id);
        $documento = Documento::find($request->documento_id);

        // Archivo
        $nombreArchivo ="";
        if ($request->hasFile('ruta')){
            $fichero = $request->file('ruta');
            $extension = $fichero->extension();

            $nombreArchivo = str_replace(' ', '_', eliminar_tildes(time().'_'.$documento->subTipo.'_'.$miembro->id.'_'.$miembro->nombre.'_'.$miembro->apellido1.'_'.$miembro->apellido2.'.'.$extension));
            $fichero->move(public_path().'/docs/', $nombreArchivo);
            
            if ($request->f_caducidad != ''){
                $miembro->documentos()->attach($request->input('documento_id'), ['ruta'=> $nombreArchivo, 'f_entrega' => date('Y-m-d', strtotime($request->input('f_entrega'))), 'f_caducidad' => date('Y-m-d', strtotime($request->input('f_caducidad')))]);
            }
            else{
                $miembro->documentos()->attach($request->input('documento_id'), ['ruta'=> $nombreArchivo, 'f_entrega' => date('Y-m-d', strtotime($request->input('f_entrega')))]);
            }
        }
        
        $documentos = Documento::get();
       
        return view('documentosMiembros.docsMiembro', compact('miembro', 'documentos'));
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
    public function edit($id)
    {
        // Aquí se edita un documento
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Aquí se guarda un miembro editado
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($cadena)
    {
        // Aquí se borra un documento
        $miembro_id = substr($cadena,0,strpos($cadena, '-'));
        $documentoMiembro_id = substr($cadena,strpos($cadena, '-')+1,strlen($cadena));
        //dd($documentoMiembro_id);

        $miembro = Miembro::find($miembro_id);


        // Borramos el fichero
        $ruta = $miembro->documentos()->wherePivot('id', $documentoMiembro_id)->first()->pivot->ruta;
        //dd($ruta);
        unlink (public_path().'/docs/'.$ruta);

        // Hacemos el detach
        $miembro->documentos()->wherePivot('id', $documentoMiembro_id)->detach();

        $documentos = Documento::get();
      
        return view('documentosMiembros.docsMiembro', compact('miembro', 'documentos'));

    }

    /**
     * Muestra los documentos de un miembro.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function docsMiembro($id)
    {
        // 
        $miembro = Miembro::find($id);
        $documentos = Documento::get();

        return view('documentosMiembros.docsMiembro', compact('miembro', 'documentos'));
    }

}
