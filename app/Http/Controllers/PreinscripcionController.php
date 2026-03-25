<?php

namespace BMLaguna\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use BMLaguna\Preinscripcion;
use BMLaguna\Genero;
use BMLaguna\Miembro;
use BMLaguna\Telefono;
use BMLaguna\Email;
use BMLaguna\Pago;
use BMLaguna\Tipospago;
use BMLaguna\Categoria;

use BMLaguna\Temporada;
use BMLaguna\Contador_recibo;

use Mail;
use Session;
use Redirect;
use Barryvdh\DomPDF\Facade as PDF;
use JavaScript;


class PreinscripcionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function index(Request $request)
    {
        // Sacamos el tipo de listado que queremos
        if (!is_null($request->input('tipo'))){
            $tipoListado = $request->input('tipo');
        }
        else{
            $tipoListado = 'Todas';
        }

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

        // Lista de Categorías
        $categorias = Categoria::all()->sortBy('orden');
        if ($request->get('categoria_id') == '') {
            $catActual_id = null;
        }
        else{
            $catActual_id = $request->get('categoria_id');
        }
        $catElegida = Categoria::find($catActual_id);

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

        // Totales
        $total['Pendientes'] =  Preinscripcion::where('temporada_id', $tempActual_id)->
                                    where('estado', 'Pendiente de Pago')->count();
        $total['Pagadas'] =     Preinscripcion::where('temporada_id', $tempActual_id)->
                                    where('estado', 'Pagado')->count();
        $total['Todas'] =       Preinscripcion::where('temporada_id', $tempActual_id)->count();

        // Estado de la preinscripcion
        if ($tipoListado == 'Pendientes') {
            $estado = 'Pendiente de Pago';
        }
        elseif ($tipoListado == 'Pagadas') {
            $estado = 'Pagado';
        }
        else {
            $estado = null;
        }

        // Query de Búsqueda con criterios
        $preinscripcionesQuery = Preinscripcion::where('temporada_id', $tempActual_id)->
            orderBy('nPreinscripcion');

        if (!is_null($textoBusqueda)){
            $preinscripcionesQuery = $preinscripcionesQuery->where(DB::raw("concat(nombre, ' ', apellido1, ' ', IFNULL(apellido2, ' '))"), "like",  "%$textoBusqueda%");
        }

        if (!is_null($genActual_id)){
            $preinscripcionesQuery = $preinscripcionesQuery->where('genero_id', $genActual_id);
        }

        if (!is_null($estado)){
            $preinscripcionesQuery = $preinscripcionesQuery->where('estado', $estado);
        }

        if (!is_null($catActual_id)){
            $preinscripcionesQuery = $preinscripcionesQuery->whereYear('f_nacimiento','>=', $catElegida->rangoAnnos($tempElegida)[0])->
                whereYear('f_nacimiento','<=', $catElegida->rangoAnnos($tempElegida)[1]);

        }
        //----------------------------------------------------------

       /*  $preinscripcionesNP = $totalPreinscripciones->get(); */
        $preinscripciones = $preinscripcionesQuery->paginate(10);

        $path = $request->url().'?temporada_id='.$tempActual_id.'&tipo='.$tipoListado.'&nombre='.$textoBusqueda. '&categoria_id='.$catActual_id. '&genero_id='.$genActual_id;

        return view('preinscripciones.index', compact('preinscripciones', 'total', 'categorias', 'catActual_id', 'generos', 'genActual_id', 'temporadas', 'tempElegida', 'tempActual_id', 'tipoListado', 'path', 'textoBusqueda'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $miembro_id = 0)
    {
        //$funciones = Funcione::all();
        //$responsables = Miembro::whereNull('f_nacimiento')->orWhere('f_nacimiento', '<', '2000/01/01')->get();
        $generos = Genero::where('descripcion', '!=', 'mixto')->get();
        $temporada = Temporada::actual();
        $miembro = Miembro::find($miembro_id);
        if (!is_null($miembro)){
            $resp1 = Miembro::find($miembro->responsable1_id);
            $resp2 = Miembro::find($miembro->responsable2_id);
        }
        else{
            $resp1 = null;
            $resp2 = null;
        }
        $telefono = Telefono::where('miembro_id', $miembro_id)->first();
        $email = Email::where('miembro_id', $miembro_id)->first();

//dd($request->route()->uri);
        if ($request->route()->uri == 'crear-preins/{miembro_id}'){
            $quitaBarra = true;
        }
        else{
            $quitaBarra = null;
        }
        $dorsales = range(1,99);

        return view('preinscripciones.create', compact('generos', 'temporada', 'miembro', 'resp1', 'resp2', 'telefono', 'email', 'quitaBarra', 'dorsales'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Ver si ya existe alguna preinscripción dada de alta
        // Si el miembro antiguo ya tiene preinscripción
/*         $preExiste = Preinscripcion::where('miembro_id', $request->input('miembro_id'))->first();
        if (!is_null($preExiste)){
            return view("preinscripciones.existe", compact('preExiste'));
        }
 */
        // Si el NIF ya existe en la preinscripción en la temporada actual.
        if (!is_null($request->input('nif'))){
            $preExiste = Preinscripcion::where('nif', $request->input('nif'))->where('temporada_id',Temporada::actual()->id)->first();
            if (!is_null($preExiste)){
                return view("preinscripciones.existe", compact('preExiste'));
            }
        }

        // Generar nùmero de preinscripción
        $nPreinscripcion = time();

        // 1.- Guardar los datos en la tabla preinscripciones
        $miembro = new Preinscripcion();

        $miembro->nif = $request->input('nif');

        if (!is_null($request->input('f_nacimiento'))){
            $miembro->f_nacimiento = date('Y-m-d', strtotime($request->input('f_nacimiento')) );
        }

        $miembro->genero_id = $request->input('genero_id');
        $miembro->nombre = $request->input('nombre');
        $miembro->apellido1 = $request->input('apellido1');
        $miembro->apellido2 = $request->input('apellido2');
        $miembro->centroEducativo = $request->input('centroEducativo');
        $miembro->nomSerigrafia = $request->input('nomSerigrafia');
        $miembro->dorsal = $request->input('dorsal');
        $miembro->domicilio = $request->input('domicilio');
        $miembro->c_postal = $request->input('c_postal');
        $miembro->provincia = $request->input('provincia');
        $miembro->localidad = $request->input('localidad');
        $miembro->nombreR1 = $request->input('nombreR1');
        $miembro->apellido1R1 = $request->input('apellido1R1');
        $miembro->apellido2R1 = $request->input('apellido2R1');
        $miembro->nombreR2 = $request->input('nombreR2');
        $miembro->apellido1R2 = $request->input('apellido1R2');
        $miembro->apellido2R2 = $request->input('apellido2R2');
        $miembro->telefono = $request->input('telefono');
        $miembro->telefonoFijo = $request->input('telefonoFijo');
        $miembro->telefonoOtro = $request->input('telefonoOtro');
        $miembro->email = $request->input('email');
        $miembro->miembro_id = $request->input('miembro_id');

        $miembro->temporada_id = Temporada::actual()->id;
        $miembro->estado = 'Pendiente de Pago';

        $miembro->f_preinscripcion = date('Y-m-d', time() );
        $miembro->nPreinscripcion = $nPreinscripcion;

        $miembro->socio = $request->input('socio');
        /* $miembro->normas = $request->input('normas'); */
        $miembro->normas = 'S';
        $miembro->autorizacion = $request->input('autorizacion');

        $miembro->obsEnfermedad = $request->input('obsEnfermedad');
        $miembro->obsAlergia = $request->input('obsAlergia');
        $miembro->obsOtras = $request->input('obsOtras');

        // Importe de la cuota
        $vPago = $request->input('importePago');
        if ($vPago == 0){
            // Ver la cuota correspondiente
            $vPago = $miembro->cuota();
        }
        else {
            $vPago = $miembro->cuota()/2;
        }

        $miembro->importePago = $vPago;

        $miembro->save();

        // 2.- Enviar correo para el pago
         $for = $request->input('email');

        Mail::send('emails.preinsConf', compact('nPreinscripcion', 'vPago'), function($msj) use ($for){
            $msj->subject('Instrucciones para el pago de la preinscripción');
            $msj->to($for);
        });

        return view("preinscripciones.salida", compact('nPreinscripcion', 'vPago'));
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
        $preinscripcion = Preinscripcion::find($id);
        $preinscripcion->delete();

        return redirect()->back()->with('status', 'Preinscripción borrada');
    }

    /* Esta función pasa al estado pagado una preinscripción */
    public function pagado(Preinscripcion $preinscripcion){
        //dd($id);

        // 1.- Sacar datos de la preinscripcion
        //$preinscripcion = new Preinscripcion();
        //$preinscripcion = Preinscripcion::find($id);

        // 2.- Actualizar campos de estado y fecha de pago.
        $preinscripcion->estado = 'Pagado';
        $preinscripcion->f_pago = date('Y-m-d', time() );

        $temporada = Temporada::find($preinscripcion->temporada_id);
        $preinscripcion->nRecibo = 'R'.$temporada->temporada.'-'.Contador_recibo::sumar($temporada);

        // Si la preinscripción es de un jugador nuevo, añadir este a los miembros
        if (is_null($preinscripcion->miembro_id)){
            // Es nuevo. Lo metemos en la base de datos.
            $miembro = Miembro::nuevo($preinscripcion);
            $preinscripcion->miembro_id = $miembro->id;
        }

        // añadimos el pago
        $pago = new Pago();

        $pago->importe = $preinscripcion->importePago;
        $pago->temporada_id = $preinscripcion->temporada_id;
        $pago->miembro_id = $preinscripcion->miembro_id;
        $pago->nRecibo = $preinscripcion -> nRecibo;
        $pago->tipospago_id = Tipospago::where('descripcion', 'Preinscripción')->first()->id;
        $pago->f_pago = date('Y-m-d', strtotime($preinscripcion->f_pago) );

        $pago->save();

        $preinscripcion->save();

        $pdf = PDF::loadview('pdf.preinscripcionPagada', compact('preinscripcion'))->setPaper('a5', 'landscape');

        // Envío de correo con el recibo adjunto
        $for = $preinscripcion->email;
        $nPreinscripcion = $preinscripcion->nPreinscripcion;

        Mail::send('emails.preinsPagada', compact('nPreinscripcion'), function($msj) use ($for, $pdf){
            $msj->subject('Preinscripción Club Balonmano Laguna');
            $msj->to($for);
            $msj->attachData($pdf->output(), 'Recibo.pdf');
        });

        return redirect()->back()->with('status', 'Recibo enviado correctamente');
    }

    public function deshacerPago(Preinscripcion $preinscripcion){
        // 1.- Sacar datos de la preinscripcion
        //$preinscripcion = new Preinscripcion();
        //$preinscripcion = Preinscripcion::find($id);

        // 2.- Actualizar campos de estado y fecha de pago.
        $preinscripcion->estado = 'Pendiente de Pago';
        $preinscripcion->f_pago = null;

        $preinscripcion->save();

        // Borrar el pago de la preinscripción
        $tipopagopre_id = Tipospago::where('descripcion', 'Preinscripción')->first()->id;
        $pago = Pago::where('miembro_id', $preinscripcion->miembro_id)->
                where('temporada_id', $preinscripcion->temporada_id)->
                where('tipospago_id', $tipopagopre_id)->first();

        $pago->delete();

        return redirect()->back()->with('status', 'Pago deshecho correctamente');
    }

    public function preinsOficinaCreate(Miembro $miembro)
    {
        //$funciones = Funcione::all();
        //$responsables = Miembro::whereNull('f_nacimiento')->orWhere('f_nacimiento', '<', '2000/01/01')->get();
        $generos = Genero::where('descripcion', '!=', 'mixto')->get();
        $temporada = Temporada::actual();
        //$miembro = Miembro::find($miembro_id);
        if (!is_null($miembro)){
            $resp1 = Miembro::find($miembro->responsable1_id);
            $resp2 = Miembro::find($miembro->responsable2_id);
        }
        else{
            $resp1 = null;
            $resp2 = null;
        }
        $telefono = Telefono::where('miembro_id', $miembro->id)->first();
        $email = Email::where('miembro_id', $miembro->id)->first();

        $dorsales = range(1,99);

        return view('preinscripciones.oficinaCreate', compact('generos', 'temporada', 'miembro', 'resp1', 'resp2', 'telefono', 'email', 'dorsales'));
    }

    public function imprimeRecibo($preinscripcion){
        $pdf = PDF::loadview('pdf.preinscripcionPagada', compact('preinscripcion'))->setPaper('a5', 'landscape');
        return $pdf->download('Recibo.pdf');
    }

    public function oficinaStore(Request $request)
    {
        // Ver si ya existe alguna preinscripción dada de alta
        // Si el miembro antiguo ya tiene preinscripción
/*         $preExiste = Preinscripcion::where('miembro_id', $request->input('miembro_id'))->first();
        if (!is_null($preExiste)){
            return view("preinscripciones.existe", compact('preExiste'));
        }
 */

        // Si el NIF ya existe en la preinscripción.
        if (!is_null($request->input('nif'))){
            $preExiste = Preinscripcion::where('nif', $request->input('nif'))->where('temporada_id',Temporada::actual()->id)->first();
            if (!is_null($preExiste)){
                return view("preinscripciones.existe", compact('preExiste'));
            }
        }

        // Generar nùmero de preinscripción
        $nPreinscripcion = time();

        // 1.- Guardar los datos en la tabla preinscripciones
        $miembro = new Preinscripcion();

        $miembro->nif = $request->input('nif');

        if (!is_null($request->input('f_nacimiento'))){
            $miembro->f_nacimiento = date('Y-m-d', strtotime($request->input('f_nacimiento')) );
        }

        $miembro->genero_id = $request->input('genero_id');
        $miembro->nombre = $request->input('nombre');
        $miembro->apellido1 = $request->input('apellido1');
        $miembro->apellido2 = $request->input('apellido2');
        $miembro->centroEducativo = $request->input('centroEducativo');
        $miembro->nomSerigrafia = $request->input('nomSerigrafia');
        $miembro->dorsal = $request->input('dorsal');
        $miembro->domicilio = $request->input('domicilio');
        $miembro->c_postal = $request->input('c_postal');
        $miembro->provincia = $request->input('provincia');
        $miembro->localidad = $request->input('localidad');
        $miembro->nombreR1 = $request->input('nombreR1');
        $miembro->apellido1R1 = $request->input('apellido1R1');
        $miembro->apellido2R1 = $request->input('apellido2R1');
        $miembro->nombreR2 = $request->input('nombreR2');
        $miembro->apellido1R2 = $request->input('apellido1R2');
        $miembro->apellido2R2 = $request->input('apellido2R2');
        $miembro->telefono = $request->input('telefono');
        $miembro->telefonoFijo = $request->input('telefonoFijo');
        $miembro->telefonoOtro = $request->input('telefonoOtro');
        $miembro->email = $request->input('email');
        $miembro->miembro_id = $request->input('miembro_id');

        $miembro->temporada_id = Temporada::actual()->id;
        $miembro->estado = 'Pagado';

        $miembro->f_preinscripcion = date('Y-m-d', time() );
        $miembro->f_pago = date('Y-m-d', time() );
        $miembro->nPreinscripcion = $nPreinscripcion;

        $miembro->obsEnfermedad = $request->input('obsEnfermedad');
        $miembro->obsAlergia = $request->input('obsAlergia');
        $miembro->obsOtras = $request->input('obsOtras');

        $miembro->socio = $request->input('socio');
        $miembro->autorizacion = $request->input('autorizacion');
        $miembro->normas = 'S';

        $temporada = Temporada::find($miembro->temporada_id);
        $miembro->nRecibo = 'R'.$temporada->temporada.'-'.Contador_recibo::sumar($temporada);

        // Importe de la cuota
        $vPago = $request->input('importePago');
        if ($vPago == 0){
            // Ver la cuota correspondiente
            $vPago = $miembro->cuota();
        }
        else {
            $vPago = $miembro->cuota()/2;
        }

        $miembro->importePago = $vPago;

        $miembro->save();

        // añadimos el pago
        $pago = new Pago();

        $pago->importe = $vPago;
        $pago->temporada_id = $miembro->temporada_id;
        $pago->miembro_id = $miembro->miembro_id;
        $pago->nRecibo = $miembro->nRecibo;
        $pago->tipospago_id = Tipospago::where('descripcion', 'Preinscripción')->first()->id;
        $pago->f_pago = date('Y-m-d', strtotime($miembro->f_pago) );

        $pago->save();

        $miembro->save();

        $preinscripcion = $miembro;

        if (!is_null($request->input('enviar'))){

            // Envío de correo con el recibo adjunto
            $pdf = PDF::loadview('pdf.preinscripcionPagada', compact('preinscripcion'))->setPaper('a5', 'landscape');

            $for = $miembro->email;
            $nPreinscripcion = $miembro->nPreinscripcion;

            Mail::send('emails.preinsPagada', compact('nPreinscripcion'), function($msj) use ($for, $pdf){
                $msj->subject('Recibo del pago de la preinscripción');
                $msj->to($for);
                $msj->attachData($pdf->output(), 'Recibo.pdf');
            });
        }

/*         if (!is_null($request->input('imprimir'))){
            // Mostrar el pdf del recibo.
            $pdf = PDF::loadview('pdf.preinscripcionPagada', compact('preinscripcion'))->setPaper('a5', 'landscape');
            return $pdf->download('Recibo.pdf');

        }
 */
        return redirect()->route('miembros')->with('status', 'Preinscripción realizada correctamente');
    }

    public function prePago(Preinscripcion $preinscripcion){
        //dd ($preinscripcion);

        return view("preinscripciones.prepago", compact('preinscripcion'));
    }
}
