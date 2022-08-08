<?php

namespace BMLaguna\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

use BMLaguna\Temporada;
use BMLaguna\Tipospago;
use BMLaguna\Pago;
use BMLaguna\Miembro;
use BMLaguna\Funcione;
use BMLaguna\Categoria;
use BMLaguna\Genero;
use BMLaguna\Equipo;

use BMLaguna\Contador_recibo;

use stdClass;

class PagosMiembroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($miembro_id, Request $request)
    {
        $temporadas = Temporada::orderBy('temporada', 'desc')->get();

        if ($request->get('tempSelect_id') == '') {
            // $tempActual_id = Temporada::actual()->id;
            $tempAct = Temporada::orderBy('temporada', 'desc')->first();
        }
        else{
            // $tempActual_id = $request->get('tempSelect_id');
            $tempAct = Temporada::find($request->get('tempSelect_id'));
        }

        $tipospagos = Tipospago::all();

        //$tempAct = Temporada::orderBy('temporada', 'desc')->first();

        // Pagos hechos por el miembro en la temporada actual
        $pagos = Pago::where('miembro_id', $miembro_id)->
                       where('temporada_id', $tempAct->id)->get();

        // Cuota anual que debe pagar
        $miembro = Miembro::find($miembro_id);
        
        $cuota = $miembro->categoria($tempAct->temporada)->precio_inscripcion;
        if (!is_null($pagos->first())){
            $pagado = $pagos->first()->sumPagado();
        }
        else{
            $pagado = 0;
        }

        return view('pagosMiembro.index', compact('miembro_id', 'temporadas', 'tipospagos', 'pagos', 'miembro', 'cuota', 'pagado', 'tempAct'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $temporadas = $temporadas = Temporada::orderBy('temporada', 'desc')->get();
        // $tipospagos = Tipospago::all();

        // $tempAct = Temporada::orderBy('temporada', 'desc')->first();

        // // Pagos hechos por el miembro en la temporada actual
        // $pagos = Pago::where('miembro_id', $miembro_id)->
        //                where('temporada_id', $tempAct->id)->get();

        // // Cuota anual que debe pagar
        // $miembro = Miembro::find($miembro_id);
        
        // $cuota = $miembro->categoria($tempAct->temporada)->precio_inscripcion;

        // return view('pagosMiembro.create', compact('miembro_id', 'temporadas', 'tipospagos', 'pagos', 'miembro', 'cuota', 'tempAct'));        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pago = new Pago();

        $pago->importe = $request->input('importe');
        $pago->temporada_id = $request->input('temporada_id');
        $pago->miembro_id = $request->input('miembro_id');
        $pago->tipospago_id = $request->input('tipospago_id');
        $pago->f_pago = date('Y-m-d', strtotime($request->input('f_pago')) );
     
        $temporada = Temporada::find($pago->temporada_id);
        $pago->nRecibo = 'R'. $temporada->temporada.'-'.Contador_recibo::sumar($temporada);

        $pago->save();

        $miembro_id = $pago->miembro_id;
        $temporadas = Temporada::orderBy('temporada', 'desc')->get();

        $tempAct = Temporada::find($pago->temporada_id);

        $tipospagos = Tipospago::all();

        // $tempAct = Temporada::orderBy('temporada', 'desc')->first();

        // Pagos hechos por el miembro en la temporada actual
        $pagos = Pago::where('miembro_id', $miembro_id)->
                       where('temporada_id', $tempAct->id)->get();

        // Cuota anual que debe pagar
        $miembro = Miembro::find($miembro_id);
        
        $cuota = $miembro->categoria($tempAct->temporada)->precio_inscripcion;
        if (!is_null($pagos->first())){
            $pagado = $pagos->first()->sumPagado();
        }
        else{
            $pagado = 0;
        }

        return view('pagosMiembro.index', compact('miembro_id', 'temporadas', 'tipospagos', 'pagos', 'miembro', 'cuota', 'pagado', 'tempAct'));        
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
