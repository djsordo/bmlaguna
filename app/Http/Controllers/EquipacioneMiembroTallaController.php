<?php

namespace BMLaguna\Http\Controllers;

use Illuminate\Http\Request;
use BMLaguna\Miembro;
use BMLaguna\Equipacione;
use BMLaguna\Temporada;

class EquipacioneMiembroTallaController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($miembro_id)
    {
        // dd($miembro_id);
        $miembro = Miembro::find($miembro_id);
        $equipaciones = Equipacione::where('temporada_id', Temporada::Tactual()->id)->get();
        $equipacionesMiembro = $miembro->equipaciones()->get();
        // dd($equipaciones);

        return view('equipacioneMiembroTalla.edit', compact('miembro', 'equipaciones', 'equipacionesMiembro'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $miembro_id)
    {
        $miembro = Miembro::find($miembro_id);
        $miembro->nomSerigrafia = $request->get('nomSerigrafia');
        $miembro->save();

        $tallas = $request->get('tallas');
        $f_pruebas = $request->get('f_pruebas');
        $f_pedidos = $request->get('f_pedidos');
        $f_llegadas = $request->get('f_llegadas');
        $f_envioseris = $request->get('f_envioseris');
        $f_llegadaseris = $request->get('f_llegadaseris');
        $f_entregas = $request->get('f_entregas');

        // Borramos primero el tallaje existente
        $miembro->equipaciones()->detach();

        if (!is_null($tallas)){
            while ( ($talla_id = current($tallas)) !== False){
                $equipacion_id = key($tallas);

                $miembro->equipaciones()->attach($equipacion_id, ['talla_id' => $talla_id, 
                                                                  'f_prueba' => date('Y-m-d', strtotime($f_pruebas[$equipacion_id])),
                                                                  'f_pedido' => (!is_null($f_pedidos[$equipacion_id])) ? date('Y-m-d', strtotime($f_pedidos[$equipacion_id])) : null,
                                                                  'f_llegada' => (!is_null($f_llegadas[$equipacion_id])) ? date('Y-m-d', strtotime($f_llegadas[$equipacion_id])) : null,
                                                                  'f_envioseri' => (!is_null($f_envioseris[$equipacion_id])) ? date('Y-m-d', strtotime($f_envioseris[$equipacion_id])) : null,
                                                                  'f_llegadaseri' => (!is_null($f_llegadaseris[$equipacion_id])) ? date('Y-m-d', strtotime($f_llegadaseris[$equipacion_id])) : null,
                                                                  'f_entrega' => (!is_null($f_entregas[$equipacion_id])) ? date('Y-m-d', strtotime($f_entregas[$equipacion_id])) : null
                                                                  ]);

                next($tallas);
            }
        }

        // return redirect()->route('miembros')->with('status', $salida);
        return redirect()->route('miembros')->with('status', 'Equipación probada correctamente');
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
