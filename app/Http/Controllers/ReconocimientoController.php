<?php

namespace BMLaguna\Http\Controllers;

use Illuminate\Http\Request;
/* use PhpOffice\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings; */

use BMLaguna\Miembro;
use BMLaguna\Reconocimiento;
use BMLaguna\Temporada;

class ReconocimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($miembro_id)
    {
        $miembro = Miembro::find($miembro_id);
        //dd($miembro);
        $temporadas = Temporada::all()->sortByDesc('temporada');   

        return view('reconocimientos.create',compact('temporadas', 'miembro'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $reco = new Reconocimiento();
        $reco->fill($request->all());

        if (!is_null($request->input('f_reconocimiento'))){
            $reco->f_reconocimiento = date('Y-m-d', strtotime($request->input('f_reconocimiento')) );
        }

        $reco->save();

        //dd ($request);
        $miembro_id = $request->input('miembro_id');

        return redirect()->route('recosMiembro', $miembro_id)->with('status', 'Reconocimiento almacenado correctamente ');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $miembro = Miembro::find($id);
        $reconocimientos = Reconocimiento::where('miembro_id', $id)->get();
        //->where('temporada_id', Temporada::Tactual()->id);
//dd($reconocimientos);
        return view('reconocimientos.show', compact('miembro', 'reconocimientos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
