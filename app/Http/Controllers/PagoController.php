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

class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Lista de temporadas
        $temporadas = Temporada::all();
        if ($request->get('temporada_id') == '') {
            $tempActual_id = Temporada::actual()->id;
        }
        else{
            $tempActual_id = $request->get('temporada_id');
        }

        $tempActual = Temporada::Tactual();
        $tempElegida = Temporada::find($tempActual_id);

        // Lista de equipos de la temporada elegida
        $equipos = Equipo::where('temporada_id',$tempActual_id)->get();
        if ($request->get('equipo_id') == '') {
            $equipoActual_id = null;
        }
        else{
            $equipoActual_id = $request->get('equipo_id');
        }
        $equipoElegido = Equipo::find($equipoActual_id);

        // Lista de géneros
        $generos = Genero::all();
        if ($request->get('genero_id') == '') {
            $genActual_id = null;
        }
        else{
            $genActual_id = $request->get('genero_id');
        }
        $genElegido = Genero::find($genActual_id);

        // Búsqueda por nombre
        $textoBusqueda = $request->input('nombre');

        // Query de la búsqueda

        // Temporada
        $pagos = Pago::where('pagos.temporada_id', $tempActual_id)/* ->orderBy('f_pago') */;

        // Equipo
        $nJugadores = null;
        $totalAPagar = null;
        $nombreEquipo = null;
        if (!is_null($equipoActual_id)){
            if ($equipoActual_id != '0'){
                $pagos = $pagos->join('equipo_funcione_miembro', 'pagos.miembro_id', '=', 'equipo_funcione_miembro.miembro_id')->
                                join('funciones', 'funciones.id', '=', 'equipo_funcione_miembro.funcione_id')->
                                join('equipos', 'equipos.id', '=', 'equipo_funcione_miembro.equipo_id')->
                                where('equipos.temporada_id', $tempActual_id)->
                                where('equipo_funcione_miembro.equipo_id', $equipoActual_id)->
                                where('funciones.descripcion', 'jugador');

                $equipo = Equipo::find($equipoActual_id);
                $nombreEquipo = $equipo->categoria->descripcion.'-'.$equipo->genero->descripcion.'-'.$equipo->nombre;
                $nJugadores = $equipo->jugadores->count();
                $totalAPagar = ($equipo->categoria->precio_inscripcion)*$nJugadores;
            }
            else{
                $pagos = $pagos->whereNotExists(function ($query) use ($tempActual_id) {
                    $query->select(DB::raw(1))
                            ->from ('equipo_funcione_miembro')
                            ->join('equipos', 'equipos.id', '=', 'equipo_funcione_miembro.equipo_id')
                            ->whereRaw('pagos.miembro_id = equipo_funcione_miembro.miembro_id and equipos.temporada_id = ' . $tempActual_id);
                });

            }
        }

        if (!is_null($textoBusqueda)){
            $pagos = $pagos->join('miembros', 'miembros.id', '=', 'pagos.miembro_id')
                           ->where(DB::raw("concat(miembros.nombre, ' ', miembros.apellido1, ' ', IFNULL(miembros.apellido2, ' '))"), "like",  "%$textoBusqueda%");
        }

        $totalPagos = $pagos->sum('pagos.importe');

        $pagos = $pagos->select('pagos.miembro_id', 'pagos.temporada_id')->groupBy('pagos.miembro_id', 'pagos.temporada_id');

        $pagos = $pagos->paginate(10);

        $path = $request->url().'?temporada_id='.$tempActual_id.'&nombre='.$textoBusqueda. '&equipo_id='.$equipoActual_id. '&genero_id='.$genActual_id;

        return view('pagos.index', compact('pagos', 'totalPagos', 'nJugadores', 'totalAPagar', 'nombreEquipo', 'equipos', 'equipoActual_id', 'generos', 'genActual_id', 'temporadas', 'tempElegida', 'tempActual_id', 'textoBusqueda', 'path'));
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function miembroCreate($miembro_id)
    {
        // $temporadas = Temporada::all();
        // $tipospagos = Tipospago::all();

        // $tempAct = Temporada::orderBy('temporada', 'desc')->first();

        // // Pagos hechos por el miembro en la temporada actual
        // $pagos = Pago::where('miembro_id', $miembro_id)->
        //                where('temporada_id', $tempAct->id)->get();

        // // Cuota anual que debe pagar
        // $miembro = Miembro::find($miembro_id);

        // $cuota = $miembro->categoria($tempAct->temporada)->precio_inscripcion;

        // return view('pagos.create', compact('miembro_id', 'temporadas', 'tipospagos', 'pagos', 'miembro', 'cuota', 'tempAct'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $pago = new Pago();

        // $pago->importe = $request->input('importe');
        // $pago->temporada_id = $request->input('temporada_id');
        // $pago->miembro_id = $request->input('miembro_id');
        // $pago->tipospago_id = $request->input('tipospago_id');
        // $pago->f_pago = date('Y-m-d', strtotime($request->input('f_pago')) );

        // $temporada = Temporada::find($pago->temporada_id);
        // $pago->nRecibo = 'R'. $temporada->temporada.'-'.Contador_recibo::sumar($temporada);

        // $pago->save();

        // $miembro_id = $pago->miembro_id;
        // $temporadas = Temporada::all();

        // if ($request->get('tempSelect_id') == '') {
        //     // $tempActual_id = Temporada::actual()->id;
        //     $tempAct = Temporada::orderBy('temporada', 'desc')->first();
        // }
        // else{
        //     // $tempActual_id = $request->get('tempSelect_id');
        //     $tempAct = Temporada::find($request->get('tempSelect_id'));
        // }


        // $tipospagos = Tipospago::all();

        // // $tempAct = Temporada::orderBy('temporada', 'desc')->first();

        // // Pagos hechos por el miembro en la temporada actual
        // $pagos = Pago::where('miembro_id', $miembro_id)->
        //                where('temporada_id', $tempAct->id)->get();

        // // Cuota anual que debe pagar
        // $miembro = Miembro::find($miembro_id);

        // $cuota = $miembro->categoria($tempAct->temporada)->precio_inscripcion;
        // if (!is_null($pagos->first())){
        //     $pagado = $pagos->first()->sumPagado();
        // }
        // else{
        //     $pagado = 0;
        // }

        // return view('pagos.miembroIndex', compact('miembro_id', 'temporadas', 'tipospagos', 'pagos', 'miembro', 'cuota', 'pagado', 'tempAct'));
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

    public function miembroIndex($miembro_id, Request $request)
    {
        // $temporadas = Temporada::all();

        // if ($request->get('tempSelect_id') == '') {
        //     // $tempActual_id = Temporada::actual()->id;
        //     $tempAct = Temporada::orderBy('temporada', 'desc')->first();
        // }
        // else{
        //     // $tempActual_id = $request->get('tempSelect_id');
        //     $tempAct = Temporada::find($request->get('tempSelect_id'));
        // }


        // $tipospagos = Tipospago::all();

        // //$tempAct = Temporada::orderBy('temporada', 'desc')->first();

        // // Pagos hechos por el miembro en la temporada actual
        // $pagos = Pago::where('miembro_id', $miembro_id)->
        //                where('temporada_id', $tempAct->id)->get();

        // // Cuota anual que debe pagar
        // $miembro = Miembro::find($miembro_id);

        // $cuota = $miembro->categoria($tempAct->temporada)->precio_inscripcion;
        // if (!is_null($pagos->first())){
        //     $pagado = $pagos->first()->sumPagado();
        // }
        // else{
        //     $pagado = 0;
        // }

        // return view('pagos.miembroIndex', compact('miembro_id', 'temporadas', 'tipospagos', 'pagos', 'miembro', 'cuota', 'pagado', 'tempAct'));
    }

}
