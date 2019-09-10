<?php

namespace BMLaguna\Http\Controllers;

use Illuminate\Http\Request;
use BMLaguna\Documento;

use BMLaguna\Http\Requests\StoreDocumentoRequest;
use BMLaguna\Http\Requests\UpdateDocumentoRequest;

class DocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documentos = Documento::orderBy('tipo')->orderBy('subTipo')->get();

        return view('documentos.index', compact('documentos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('documentos.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDocumentoRequest $request)
    {
        $documento = new Documento();

        $documento->descripcion = $request->input('descripcion');
        $documento->tipo = $request->input('tipo');
        $documento->subTipo = $request->input('subTipo');

        $documento->save();

        return redirect()->route('documentos')->with('status', 'Tipo de documento creado correctamente');
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
    public function edit(Documento $documento)
    {
        return view('documentos.edit', compact('documento'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDocumentoRequest $request, Documento $documento)
    {
        $documento->descripcion = $request->input('descripcion');
        $documento->tipo = $request->input('tipo');
        $documento->subTipo = $request->input('subTipo');

        $documento->save();

        return redirect()->route('documentos')->with('status', 'Tipo de documento actualizado correctamente');

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
